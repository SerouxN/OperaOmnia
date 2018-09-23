<?php

// Author: de77.com
// Licence: MIT
// Homepage: http://de77.com/php/extract-title-author-and-number-of-pages-from-pdf-with-php
// Version: 21.07.2010


class PDFInfo
{
	public $author;
	public $title;
	public $pages;
	
	public function load($filename)
	{
		$string = file_get_contents($filename);
		
		$start = strpos($string, "<dc:title>") + 10;
		$length = strpos(substr($string, $start), '</dc:title>');

		$this->title = 'Untitled';
		if ($length) 
		{
			$this->title = strip_tags(substr($string, $start, $length));
			$this->title = $this->pdfDecTxt($this->title);
		}
		
		$start = strpos($string, "<dc:creator>") + 12;
		$length = strpos(substr($string, $start), '</dc:creator>');
		$this->author = 'Unknown';
		
		if ($length) 
		{
			$this->author = strip_tags(substr($string, $start, $length));
			$this->author = $this->pdfDecTxt($this->author);
		}
		
		if (preg_match("/\/N\s+([0-9]+)/", $string, $found))
		{
			$this->pages = $found[1]; 
		}
		else
		{
			$pos = strpos($string, '/Type /Pages ');
			if ($pos !== false)
			{
				$pos2 = strpos($string, '>>', $pos);
				$string = substr($string, $pos, $pos2 - $pos);
				$pos = strpos($string, '/Count ');
				$this->pages = (int) substr($string, $pos+7);
			}
		}
		$data;
	}
	private function pdfDecTxt($txt)
	{
		$len = strlen($txt);
		$out = '';
		$i = 0;
		while ($i<$len)
		{
			if ($txt[$i] == '\\')
			{
				$out .= chr(octdec(substr($txt, $i+1, 3)));
				$i += 4;			
			}
			else
			{
				$out .= $txt[$i];
				$i++;
			}
		}
		
		if ($out[0] == chr(254))
		{
			$enc = 'UTF-16';
		}
		else
		{
			$enc = mb_detect_encoding($out);
		}

		return iconv($enc, 'UTF-8', $out);
	}
}