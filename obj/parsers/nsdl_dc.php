<?php
// @package LR-PHP
// @copyright 2012 Jeffrey Hill/Jason Hoekstra
// @license Apache 2.0 License http://www.apache.org/licenses/LICENSE-2.0.html

defined('LREXEC') or die('Access Denied');

class LRParserNSDL_DC extends LRParser
{
	public static $version = '1.0.2.0';
	public static $xml;

	public function build()
	{
		self::$xml = new DOMDocument();
		self::$xml->formatOutput = true;
		$nsdl_dc = self::$xml->createElement( 'nsdl_dc:nsdl_dc' );
		$nsdl_dc->setAttribute( 'xmlns:nsdl_dc', 'http://ns.nsdl.org/nsdl_dc_v1.02' );
		$nsdl_dc->setAttribute( 'xmlns:dc', 'http://purl.org/dc/elements/1.1/' );
		$nsdl_dc->setAttribute( 'xmlns:dct', 'http://purl.org/dc/terms/' );
		$nsdl_dc->setAttribute( 'xmlns:ieee', 'http://www.ieee.org/xsd/LOMv1p0' );
		$nsdl_dc->setAttribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
		$nsdl_dc->setAttribute( 'xmlns', 'http://www.openarchives.org/OAI/2.0/' );
		$nsdl_dc->setAttribute( 'schemaVersion', self::$version);
		$nsdl_dc->setAttribute( 'xsi:schemaLocation', 'http://ns.nsdl.org/nsdl_dc_v1.02/ http://ns.nsdl.org/schemas/nsdl_dc/nsdl_dc_v1.02.xsd' );
		
		// Title is required
		$dc_title = self::$xml->createElement('dc:title');
		$dc_title->appendChild(self::$xml->createTextNode(self::$instance->data['title']));
		$nsdl_dc->appendChild($dc_title);
		
		// Alternative Title is recommended, if applicable
		if(!empty(self::$instance->data['alternative']))
		{
			$dc_alternative_title = self::$xml->createElement('dct:alternative');
			$dc_alternative_title->appendChild(self::$xml->createTextNode(self::$instance->data['alternative']));
			$nsdl_dc->appendChild($dc_alternative_title);
		}
		
		// Identifier is required
		$dc_identifier = self::$xml->createElement('dc:identifier');
		self::_setXSIType($dc_identifier, 'URI');
		$dc_identifier->appendChild(self::$xml->createTextNode(self::$instance->data['url']));
		$nsdl_dc->appendChild($dc_identifier);
		
		// Subjects are strongly recommended
		if(!empty(self::$instance->data['subjects']))
		{
			$dct_subjects = array();
			foreach(self::$instance->data['subjects'] as $k=>$subject)
			{
				$dct_subjects[$k] = self::$xml->createElement('dc:subject');
				$dct_subjects[$k]->appendChild(self::$xml->createTextNode($subject));
				$nsdl_dc->appendChild($dct_subjects[$k]);
			}
		}
		
		// Standards SHOULD be an array of canonical URIs
		if(!empty(self::$instance->data['standards']))
		{
			$dct_conformsTo = array();
			foreach(self::$instance->data['standards'] as $k=>$standard)
			{
				$dct_conformsTo[$k] = self::$xml->createElement('dct:conformsTo');
				self::_setXSIType($dct_conformsTo[$k], 'dct', 'URI');
				$dct_conformsTo[$k]->appendChild(self::$xml->createTextNode($standard));
				$nsdl_dc->appendChild($dct_conformsTo[$k]);
			}
		}
		
		// Resource types in NSDL controller vocabulary
		$types = array(
		'Assessment Material'=>
			array('Answer Key','Portfolio','Rubric','Test'),
		'Dataset'=>
			array('Database','List/Table','Observed Data','Remotely Sensed Data','Trial'),
		'Event'=>
			array('Award/Recognition/Scholarship','Broadcast','Call for Participation',
			'Conference','Exhibit','Learning/Research Opportunity','Job','News','Workshop'),
		'Instructional Material'=>
			array('Activity','Annotation','Case Study','Course','Curriculum',
			'Demonstration','Experiment/Lab Activity','Field Trip','Game','Instructional Strategy',
			'Lecture/Presentation','Lesson/Lesson Plan','Model','Problem Set','Project','Simulation',
			'Student Guide','Syllabus','Textbook','Tutorial','Unit of Instruction'),
		'Reference Material'=>
			array('Abstract','Article','Bibliography','Career Information','Classification Key',
			'Educational Standard','FAQ','Fiction','Glossary/Index','Outline','Nonfiction Reference',
			'Periodical','Policy','Proceedings','Proposal','Report','Scientific Standard','Specimen',
			'Thesis/Dissertation'),
		'Community'=>
			array('Ask-an-Expert','Forum','Listserv','Weblog','Wiki'),
		'Tool'=>
			array('Code','Equipment','Form','Numerical Model','Search Engine','Software'),
		'Audio/Visual'=>
			array('Graph','Illustration','Image/Image Set','Map','Movie/Animation','Music',
			'Photograph','Sound','Voice Recording')
		);
		
		if(!empty(self::$instance->data['types']))
		{
			$dct_type = array();
			foreach(self::$instance->data['types'] as $k=>$type)
			{
				$dct_type[$k] = self::$xml->createElement('dct:type');
				if(in_array($type, $types))
				{
					self::_setXSIType($dct_type[$k], 'nsdl_dc', 'NSDLType');
				}
				$dct_type[$k]->appendChild(self::$xml->createTextNode($type));
				$nsdl_dc->appendChild($dct_type[$k]);
			}
		}

		// Education levels in NSDL controlled vocabulary (i.e. Grade 1, Middle School)
		if(!empty(self::$instance->data['education_levels']))
		{
			$dct_edLevel = array();
			foreach(self::$instance->data['education_levels'] as $k=>$ed_level)
			{
				$dct_edLevel[$k] = self::$xml->createElement('dct:educationLevel');
				self::_setXSIType($dct_edLevel[$k], 'nsdl_dc', 'NSDLEdLevel');
				$dct_edLevel[$k]->appendChild(self::$xml->createTextNode($ed_level));
				$nsdl_dc->appendChild($dct_edLevel[$k]);
			}
		}
		
		// Audience in NSDL controlled vocabulary (i.e. Educator, Learner, Administrator)
		$audiences = array('Administrator','Educator','General Public','Learner',
		'Parent/Guardian','Professional/Practitioner','Researcher');
		if(!empty(self::$instance->data['audiences']))
		{
			$dct_audience = array();
			foreach(self::$instance->data['audiences'] as $k=>$audience)
			{
				$dct_audience[$k] = self::$xml->createElement('dct:audience');
				// If the term fits one of those enumerated above, it's part of NSDL's controlled vocabulary
				if(in_array($audience, $audiences))
				{
					self::_setXSIType($dct_audience[$k], 'nsdl_dc', 'NSDLAudience');
				}
				$dct_audience[$k]->appendChild(self::$xml->createTextNode($audience));
				$nsdl_dc->appendChild($dct_audience[$k]);
			}
		}
		
		$dc_description = self::$xml->createElement('dc:description');
		$dc_description->appendChild(self::$xml->createTextNode(self::$instance->data['description']));
		$nsdl_dc->appendChild($dc_description);
		
		self::$xml->appendChild($nsdl_dc);
		return self::$xml->saveXML();
	}
	
	private function _setXSIType(DOMElement $el, $namespace, $type)
	{
		$xsi_type = self::$xml->createAttribute('xsi:type');
		$xsi_type->value = $namespace.':'.$type;
		$el->appendChild($xsi_type);
		return;
	}
}