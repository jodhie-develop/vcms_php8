<?php
require_once __DIR__ . "/_lib/bootstrap.php";
/**
 * A class for reading Microsoft Excel (97/2003) Spreadsheets.
 *
 * Version 2.21
 *
 * Enhanced and maintained by Matt Kruse < http://mattkruse.com >
 * Maintained at http://code.google.com/p/php-excel-reader/
 *
 * Format parsing and MUCH more contributed by:
 *    Matt Roxburgh < http://www.roxburgh.me.uk >
 *
 * DOCUMENTATION
 * =============
 *   http://code.google.com/p/php-excel-reader/wiki/Documentation
 *
 * CHANGE LOG
 * ==========
 *   http://code.google.com/p/php-excel-reader/wiki/ChangeHistory
 *
 * DISCUSSION/SUPPORT
 * ==================
 *   http://groups.google.com/group/php-excel-reader-discuss/topics
 *
 * --------------------------------------------------------------------------
 *
 * Originally developed by Vadim Tkachenko under the name PHPExcelReader.
 * (http://sourceforge.net/projects/phpexcelreader)
 * Based on the Java version by Andy Khan (http://www.andykhan.com).  Now
 * maintained by David Sanders.  Reads only Biff 7 and Biff 8 formats.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Spreadsheet
 * @package	Spreadsheet_Excel_Reader
 * @author	 Vadim Tkachenko <vt@apachephp.com>
 * @license	http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version	CVS: $Id: reader.php 19 2007-03-13 12:42:41Z shangxiao $
 * @link	   http://pear.php.net/package/Spreadsheet_Excel_Reader
 * @see		OLE, Spreadsheet_Excel_Writer
 * --------------------------------------------------------------------------
 */

define('NUM_BIG_BLOCK_DEPOT_BLOCKS_POS', 0x2c);
define('SMALL_BLOCK_DEPOT_BLOCK_POS', 0x3c);
define('ROOT_START_BLOCK_POS', 0x30);
define('BIG_BLOCK_SIZE', 0x200);
define('SMALL_BLOCK_SIZE', 0x40);
define('EXTENSION_BLOCK_POS', 0x44);
define('NUM_EXTENSION_BLOCK_POS', 0x48);
define('PROPERTY_STORAGE_BLOCK_SIZE', 0x80);
define('BIG_BLOCK_DEPOT_BLOCKS_POS', 0x4c);
define('SMALL_BLOCK_THRESHOLD', 0x1000);
// property storage offsets
define('SIZE_OF_NAME_POS', 0x40);
define('TYPE_POS', 0x42);
define('START_BLOCK_POS', 0x74);
define('SIZE_POS', 0x78);
define('IDENTIFIER_OLE', pack("CCCCCCCC",0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1));


function GetInt4d($data, $pos) {
	$value = ord($data[$pos]) | (ord($data[num($pos)+1])	<< 8) | (ord($data[num($pos)+2]) << 16) | (ord($data[num($pos)+3]) << 24);
	if (num($value)>=4294967294) {
		$value=-2;
	}
	return $value;
}

// http://uk.php.net/manual/en/function.getdate.php
function gmgetdate($ts = null){
	$k = array('seconds','minutes','hours','mday','wday','mon','year','yday','weekday','month',0);
	return(array_comb($k,explode(":",gmdate('s:i:G:j:w:n:Y:z:l:F:U',is_null($ts)?time():$ts))));
	} 

// Added for PHP4 compatibility
function array_comb($array1, $array2) {
	$out = array();
	foreach ($array1 as $key => $value) {
		$out[$value] = $array2[$key];
	}
	return $out;
}

function v($data,$pos) {
	return ord($data[$pos]) | ord($data[num($pos)+1])<<8;
}

class OLERead {
	var $data = '';
	function OLERead(){	}

	function read($sFileName){
		// check if file exist and is readable (Darko Miljanovic)
		if(!is_readable($sFileName)) {
			$this->error = 1;
			return false;
		}
		$this->data = @file_get_contents($sFileName);
		if (!$this->data) {
			$this->error = 1;
			return false;
   		}
   		if (substr($this->data, 0, 8) != IDENTIFIER_OLE) {
			$this->error = 1;
			return false;
   		}
		$this->numBigBlockDepotBlocks = GetInt4d($this->data, NUM_BIG_BLOCK_DEPOT_BLOCKS_POS);
		$this->sbdStartBlock = GetInt4d($this->data, SMALL_BLOCK_DEPOT_BLOCK_POS);
		$this->rootStartBlock = GetInt4d($this->data, ROOT_START_BLOCK_POS);
		$this->extensionBlock = GetInt4d($this->data, EXTENSION_BLOCK_POS);
		$this->numExtensionBlocks = GetInt4d($this->data, NUM_EXTENSION_BLOCK_POS);

		$bigBlockDepotBlocks = array();
		$pos = BIG_BLOCK_DEPOT_BLOCKS_POS;
		$bbdBlocks = $this->numBigBlockDepotBlocks;
		if (num($this->numExtensionBlocks) != 0) {
			$bbdBlocks = num((num(BIG_BLOCK_SIZE) - num(BIG_BLOCK_DEPOT_BLOCKS_POS)))/4;
		}

		for ($i = 0; $i < $bbdBlocks; $i++) {
			$bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
			$pos = num($pos) + num((4));
		}


		for ($j = 0; $j < $this->numExtensionBlocks; $j++) {
			$pos = num((num($this->extensionBlock) + 1)) * num(BIG_BLOCK_SIZE);
			$blocksToRead = min(num($this->numBigBlockDepotBlocks) - num($bbdBlocks), num(BIG_BLOCK_SIZE) / 4 - 1);

			for ($i = $bbdBlocks; $i < num($bbdBlocks) + num($blocksToRead); $i++) {
				$bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
				$pos = num($pos) + num((4));
			}

			$bbdBlocks = num($bbdBlocks) + num(($blocksToRead));
			if ($bbdBlocks < $this->numBigBlockDepotBlocks) {
				$this->extensionBlock = GetInt4d($this->data, $pos);
			}
		}

		// readBigBlockDepot
		$pos = 0;
		$index = 0;
		$this->bigBlockChain = array();

		for ($i = 0; $i < $this->numBigBlockDepotBlocks; $i++) {
			$pos = num((num($bigBlockDepotBlocks[$i]) + 1)) * num(BIG_BLOCK_SIZE);
			//echo "pos = $pos";
			for ($j = 0 ; $j < num(BIG_BLOCK_SIZE) / 4; $j++) {
				$this->bigBlockChain[$index] = GetInt4d($this->data, $pos);
				$pos = num($pos) + num((4)) ;
				$index++;
			}
		}

		// readSmallBlockDepot();
		$pos = 0;
		$index = 0;
		$sbdBlock = $this->sbdStartBlock;
		$this->smallBlockChain = array();

		while (num($sbdBlock) != -2) {
		  $pos = num((num($sbdBlock) + 1)) * num(BIG_BLOCK_SIZE);
		  for ($j = 0; $j < num(BIG_BLOCK_SIZE) / 4; $j++) {
			$this->smallBlockChain[$index] = GetInt4d($this->data, $pos);
			$pos = num($pos) + num((4));
			$index++;
		  }
		  $sbdBlock = $this->bigBlockChain[$sbdBlock];
		}


		// readData(rootStartBlock)
		$block = $this->rootStartBlock;
		$pos = 0;
		$this->entry = $this->__readData($block);
		$this->__readPropertySets();
	}

	function __readData($bl) {
		$block = $bl;
		$pos = 0;
		$data = '';
		while (num($block) != -2)  {
			$pos = num((num($block) + 1)) * num(BIG_BLOCK_SIZE);
			$data = $data.substr($this->data, $pos, BIG_BLOCK_SIZE);
			$block = $this->bigBlockChain[$block];
		}
		return $data;
	 }

	function __readPropertySets(){
		$offset = 0;
		while ($offset < strlen($this->entry)) {
			$d = substr($this->entry, $offset, PROPERTY_STORAGE_BLOCK_SIZE);
			$nameSize = ord($d[SIZE_OF_NAME_POS]) | (ord($d[num(SIZE_OF_NAME_POS)+1]) << 8);
			$type = ord($d[TYPE_POS]);
			$startBlock = GetInt4d($d, START_BLOCK_POS);
			$size = GetInt4d($d, SIZE_POS);
			$name = '';
			for ($i = 0; $i < $nameSize ; $i++) {
				$name .= $d[$i];
			}
			$name = str_replace("\x00", "", $name);
			$this->props[] = array (
				'name' => $name,
				'type' => $type,
				'startBlock' => $startBlock,
				'size' => $size);
			if ((strtolower($name) == "workbook") || ( strtolower($name) == "book")) {
				$this->wrkbook = cnt($this->props) - 1;
			}
			if ($name == "Root Entry") {
				$this->rootentry = cnt($this->props) - 1;
			}
			$offset = num($offset) + num((PROPERTY_STORAGE_BLOCK_SIZE));
		}

	}


	function getWorkBook(){
		if ($this->props[$this->wrkbook]['size'] < SMALL_BLOCK_THRESHOLD){
			$rootdata = $this->__readData($this->props[$this->rootentry]['startBlock']);
			$streamData = '';
			$block = $this->props[$this->wrkbook]['startBlock'];
			$pos = 0;
			while (num($block) != -2) {
	  			  $pos = num($block) * num(SMALL_BLOCK_SIZE);
				  $streamData .= substr($rootdata, $pos, SMALL_BLOCK_SIZE);
				  $block = $this->smallBlockChain[$block];
			}
			return $streamData;
		}else{
			$numBlocks = div($this->props[$this->wrkbook]['size'], BIG_BLOCK_SIZE);
			if (num($this->props[$this->wrkbook]['size']) % num(BIG_BLOCK_SIZE) != 0) {
				$numBlocks++;
			}

			if (num($numBlocks) == 0) return '';
			$streamData = '';
			$block = $this->props[$this->wrkbook]['startBlock'];
			$pos = 0;
			while (num($block) != -2) {
			  $pos = num((num($block) + 1)) * num(BIG_BLOCK_SIZE);
			  $streamData .= substr($this->data, $pos, BIG_BLOCK_SIZE);
			  $block = $this->bigBlockChain[$block];
			}
			return $streamData;
		}
	}

}

define('SPREADSHEET_EXCEL_READER_BIFF8',			 0x600);
define('SPREADSHEET_EXCEL_READER_BIFF7',			 0x500);
define('SPREADSHEET_EXCEL_READER_WORKBOOKGLOBALS',   0x5);
define('SPREADSHEET_EXCEL_READER_WORKSHEET',		 0x10);
define('SPREADSHEET_EXCEL_READER_TYPE_BOF',		  0x809);
define('SPREADSHEET_EXCEL_READER_TYPE_EOF',		  0x0a);
define('SPREADSHEET_EXCEL_READER_TYPE_BOUNDSHEET',   0x85);
define('SPREADSHEET_EXCEL_READER_TYPE_DIMENSION',	0x200);
define('SPREADSHEET_EXCEL_READER_TYPE_ROW',		  0x208);
define('SPREADSHEET_EXCEL_READER_TYPE_DBCELL',	   0xd7);
define('SPREADSHEET_EXCEL_READER_TYPE_FILEPASS',	 0x2f);
define('SPREADSHEET_EXCEL_READER_TYPE_NOTE',		 0x1c);
define('SPREADSHEET_EXCEL_READER_TYPE_TXO',		  0x1b6);
define('SPREADSHEET_EXCEL_READER_TYPE_RK',		   0x7e);
define('SPREADSHEET_EXCEL_READER_TYPE_RK2',		  0x27e);
define('SPREADSHEET_EXCEL_READER_TYPE_MULRK',		0xbd);
define('SPREADSHEET_EXCEL_READER_TYPE_MULBLANK',	 0xbe);
define('SPREADSHEET_EXCEL_READER_TYPE_INDEX',		0x20b);
define('SPREADSHEET_EXCEL_READER_TYPE_SST',		  0xfc);
define('SPREADSHEET_EXCEL_READER_TYPE_EXTSST',	   0xff);
define('SPREADSHEET_EXCEL_READER_TYPE_CONTINUE',	 0x3c);
define('SPREADSHEET_EXCEL_READER_TYPE_LABEL',		0x204);
define('SPREADSHEET_EXCEL_READER_TYPE_LABELSST',	 0xfd);
define('SPREADSHEET_EXCEL_READER_TYPE_NUMBER',	   0x203);
define('SPREADSHEET_EXCEL_READER_TYPE_NAME',		 0x18);
define('SPREADSHEET_EXCEL_READER_TYPE_ARRAY',		0x221);
define('SPREADSHEET_EXCEL_READER_TYPE_STRING',	   0x207);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMULA',	  0x406);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMULA2',	 0x6);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMAT',	   0x41e);
define('SPREADSHEET_EXCEL_READER_TYPE_XF',		   0xe0);
define('SPREADSHEET_EXCEL_READER_TYPE_BOOLERR',	  0x205);
define('SPREADSHEET_EXCEL_READER_TYPE_FONT',	  0x0031);
define('SPREADSHEET_EXCEL_READER_TYPE_PALETTE',	  0x0092);
define('SPREADSHEET_EXCEL_READER_TYPE_UNKNOWN',	  0xffff);
define('SPREADSHEET_EXCEL_READER_TYPE_NINETEENFOUR', 0x22);
define('SPREADSHEET_EXCEL_READER_TYPE_MERGEDCELLS',  0xE5);
define('SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS' ,	25569);
define('SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904', 24107);
define('SPREADSHEET_EXCEL_READER_MSINADAY',		  86400);
define('SPREADSHEET_EXCEL_READER_TYPE_HYPER',	     0x01b8);
define('SPREADSHEET_EXCEL_READER_TYPE_COLINFO',	     0x7d);
define('SPREADSHEET_EXCEL_READER_TYPE_DEFCOLWIDTH',  0x55);
define('SPREADSHEET_EXCEL_READER_TYPE_STANDARDWIDTH', 0x99);
define('SPREADSHEET_EXCEL_READER_DEF_NUM_FORMAT',	"%s");


/*
* Main Class
*/
class Spreadsheet_Excel_Reader {

	// MK: Added to make data retrieval easier
	var $colnames = array();
	var $colindexes = array();
	var $standardColWidth = 0;
	var $defaultColWidth = 0;

	function myHex($d) {
		if (num($d) < 16) return "0" . dechex($d);
		return dechex($d);
	}
	
	function dumpHexData($data, $pos, $length) {
		$info = "";
		for ($i = 0; $i <= $length; $i++) {
			$info .= (num($i)==0?"":" ") . $this->myHex(ord($data[num($pos) + num($i)])) . (num(ord($data[num($pos) + num($i)]))>31? "[" . $data[num($pos) + num($i)] . "]":'');
		}
		return $info;
	}

	function getCol($col) {
		if (is_string($col)) {
			$col = strtolower($col);
			if (array_key_exists($col,$this->colnames)) {
				$col = $this->colnames[$col];
			}
		}
		return $col;
	}

	// PUBLIC API FUNCTIONS
	// --------------------

	function val($row,$col,$sheet=0) {
		$col = $this->getCol($col);
		if (array_key_exists($row,$this->sheets[$sheet]['cells']) && array_key_exists($col,$this->sheets[$sheet]['cells'][$row])) {
			return $this->sheets[$sheet]['cells'][$row][$col];
		}
		return "";
	}
	function value($row,$col,$sheet=0) {
		return $this->val($row,$col,$sheet);
	}
	function info($row,$col,$type='',$sheet=0) {
		$col = $this->getCol($col);
		if (array_key_exists('cellsInfo',$this->sheets[$sheet])
				&& array_key_exists($row,$this->sheets[$sheet]['cellsInfo'])
				&& array_key_exists($col,$this->sheets[$sheet]['cellsInfo'][$row])
				&& array_key_exists($type,$this->sheets[$sheet]['cellsInfo'][$row][$col])) {
			return $this->sheets[$sheet]['cellsInfo'][$row][$col][$type];
		}
		return "";
	}
	function type($row,$col,$sheet=0) {
		return $this->info($row,$col,'type',$sheet);
	}
	function raw($row,$col,$sheet=0) {
		return $this->info($row,$col,'raw',$sheet);
	}
	function rowspan($row,$col,$sheet=0) {
		$val = $this->info($row,$col,'rowspan',$sheet);
		if ($val=="") { return 1; }
		return $val;
	}
	function colspan($row,$col,$sheet=0) {
		$val = $this->info($row,$col,'colspan',$sheet);
		if ($val=="") { return 1; }
		return $val;
	}
	function hyperlink($row,$col,$sheet=0) {
		$link = $this->sheets[$sheet]['cellsInfo'][$row][$col]['hyperlink'];
		if ($link) {
			return $link['link'];
		}
		return '';
	}
	function rowcount($sheet=0) {
		return $this->sheets[$sheet]['numRows'];
	}
	function colcount($sheet=0) {
		return $this->sheets[$sheet]['numCols'];
	}
	function colwidth($col,$sheet=0) {
		// Col width is actually the width of the number 0. So we have to estimate and come close
		return num($this->colInfo[$sheet][$col]['width'])/9142*200; 
	}
	function colhidden($col,$sheet=0) {
		return !!$this->colInfo[$sheet][$col]['hidden'];
	}
	function rowheight($row,$sheet=0) {
		return $this->rowInfo[$sheet][$row]['height'];
	}
	function rowhidden($row,$sheet=0) {
		return !!$this->rowInfo[$sheet][$row]['hidden'];
	}
	
	// GET THE CSS FOR FORMATTING
	// ==========================
	function style($row,$col,$sheet=0,$properties='') {
		$css = "";
		$font=$this->font($row,$col,$sheet);
		if ($font!="") {
			$css .= "font-family:$font;";
		}
		$align=$this->align($row,$col,$sheet);
		if ($align!="") {
			$css .= "text-align:$align;";
		}
		$height=$this->height($row,$col,$sheet);
		if ($height!="") {
			$css .= "font-size:$height"."px;";
		}
		$bgcolor=$this->bgColor($row,$col,$sheet);
		if ($bgcolor!="") {
			$bgcolor = $this->colors[$bgcolor];
			$css .= "background-color:$bgcolor;";
		}
		$color=$this->color($row,$col,$sheet);
		if ($color!="") {
			$css .= "color:$color;";
		}
		$bold=$this->bold($row,$col,$sheet);
		if ($bold) {
			$css .= "font-weight:bold;";
		}
		$italic=$this->italic($row,$col,$sheet);
		if ($italic) {
			$css .= "font-style:italic;";
		}
		$underline=$this->underline($row,$col,$sheet);
		if ($underline) {
			$css .= "text-decoration:underline;";
		}
		// Borders
		$bLeft = $this->borderLeft($row,$col,$sheet);
		$bRight = $this->borderRight($row,$col,$sheet);
		$bTop = $this->borderTop($row,$col,$sheet);
		$bBottom = $this->borderBottom($row,$col,$sheet);
		$bLeftCol = $this->borderLeftColor($row,$col,$sheet);
		$bRightCol = $this->borderRightColor($row,$col,$sheet);
		$bTopCol = $this->borderTopColor($row,$col,$sheet);
		$bBottomCol = $this->borderBottomColor($row,$col,$sheet);
		// Try to output the minimal required style
		if ($bLeft!="" && $bLeft==$bRight && $bRight==$bTop && $bTop==$bBottom) {
			$css .= "border:" . $this->lineStylesCss[$bLeft] .";";
		}
		else {
			if ($bLeft!="") { $css .= "border-left:" . $this->lineStylesCss[$bLeft] .";"; }
			if ($bRight!="") { $css .= "border-right:" . $this->lineStylesCss[$bRight] .";"; }
			if ($bTop!="") { $css .= "border-top:" . $this->lineStylesCss[$bTop] .";"; }
			if ($bBottom!="") { $css .= "border-bottom:" . $this->lineStylesCss[$bBottom] .";"; }
		}
		// Only output border colors if there is an actual border specified
		if ($bLeft!="" && $bLeftCol!="") { $css .= "border-left-color:" . $bLeftCol .";"; }
		if ($bRight!="" && $bRightCol!="") { $css .= "border-right-color:" . $bRightCol .";"; }
		if ($bTop!="" && $bTopCol!="") { $css .= "border-top-color:" . $bTopCol . ";"; }
		if ($bBottom!="" && $bBottomCol!="") { $css .= "border-bottom-color:" . $bBottomCol .";"; }
		
		return $css;
	}
	
	// FORMAT PROPERTIES
	// =================
	function format($row,$col,$sheet=0) {
		return $this->info($row,$col,'format',$sheet);
	}
	function formatIndex($row,$col,$sheet=0) {
		return $this->info($row,$col,'formatIndex',$sheet);
	}
	function formatColor($row,$col,$sheet=0) {
		return $this->info($row,$col,'formatColor',$sheet);
	}
	
	// CELL (XF) PROPERTIES
	// ====================
	function xfRecord($row,$col,$sheet=0) {
		$xfIndex = $this->info($row,$col,'xfIndex',$sheet);
		if ($xfIndex!="") {
			return $this->xfRecords[$xfIndex];
		}
		return null;
	}
	function xfProperty($row,$col,$sheet,$prop) {
		$xfRecord = $this->xfRecord($row,$col,$sheet);
		if ($xfRecord!=null) {
			return $xfRecord[$prop];
		}
		return "";
	}
	function align($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'align');
	}
	function bgColor($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'bgColor');
	}
	function borderLeft($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'borderLeft');
	}
	function borderRight($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'borderRight');
	}
	function borderTop($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'borderTop');
	}
	function borderBottom($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'borderBottom');
	}
	function borderLeftColor($row,$col,$sheet=0) {
		return $this->colors[$this->xfProperty($row,$col,$sheet,'borderLeftColor')];
	}
	function borderRightColor($row,$col,$sheet=0) {
		return $this->colors[$this->xfProperty($row,$col,$sheet,'borderRightColor')];
	}
	function borderTopColor($row,$col,$sheet=0) {
		return $this->colors[$this->xfProperty($row,$col,$sheet,'borderTopColor')];
	}
	function borderBottomColor($row,$col,$sheet=0) {
		return $this->colors[$this->xfProperty($row,$col,$sheet,'borderBottomColor')];
	}

	// FONT PROPERTIES
	// ===============
	function fontRecord($row,$col,$sheet=0) {
	    $xfRecord = $this->xfRecord($row,$col,$sheet);
		if ($xfRecord!=null) {
			$font = $xfRecord['fontIndex'];
			if ($font!=null) {
				return $this->fontRecords[$font];
			}
		}
		return null;
	}
	function fontProperty($row,$col,$sheet=0,$prop) {
		$font = $this->fontRecord($row,$col,$sheet);
		if ($font!=null) {
			return $font[$prop];
		}
		return false;
	}
	function fontIndex($row,$col,$sheet=0) {
		return $this->xfProperty($row,$col,$sheet,'fontIndex');
	}
	function color($row,$col,$sheet=0) {
		$formatColor = $this->formatColor($row,$col,$sheet);
		if ($formatColor!="") {
			return $formatColor;
		}
		$ci = $this->fontProperty($row,$col,$sheet,'color');
                return $this->rawColor($ci);
        }
        function rawColor($ci) {
		if ((num($ci) <> 0x7FFF) && ($ci <> '')) {
			return $this->colors[$ci];
		}
		return "";
	}
	function bold($row,$col,$sheet=0) {
		return $this->fontProperty($row,$col,$sheet,'bold');
	}
	function italic($row,$col,$sheet=0) {
		return $this->fontProperty($row,$col,$sheet,'italic');
	}
	function underline($row,$col,$sheet=0) {
		return $this->fontProperty($row,$col,$sheet,'under');
	}
	function height($row,$col,$sheet=0) {
		return $this->fontProperty($row,$col,$sheet,'height');
	}
	function font($row,$col,$sheet=0) {
		return $this->fontProperty($row,$col,$sheet,'font');
	}
	
	// DUMP AN HTML TABLE OF THE ENTIRE XLS DATA
	// =========================================
	function dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel') {
		$out = "<table class=\"" . e($table_class) . "\" cellspacing=0>";
		if ($col_letters) {
			$out .= "<thead>\n\t<tr>";
			if ($row_numbers) {
				$out .= "\n\t\t<th>&nbsp</th>";
			}
			for($i=1;$i<=$this->colcount($sheet);$i++) {
				$style = "width:" . (num($this->colwidth($i,$sheet))*1) . "px;";
				if ($this->colhidden($i,$sheet)) {
					$style .= "display:none;";
				}
				$out .= "\n\t\t<th style=\"" . e($style) . "\">" . e(strtoupper($this->colindexes[$i])) . "</th>";
			}
			$out .= "</tr></thead>\n";
		}
		
		$out .= "<tbody>\n";
		for($row=1;$row<=$this->rowcount($sheet);$row++) {
			$rowheight = $this->rowheight($row,$sheet);
			$style = "height:" . (num($rowheight)*num((4/3))) . "px;";
			if ($this->rowhidden($row,$sheet)) {
				$style .= "display:none;";
			}
			$out .= "\n\t<tr style=\"" . e($style) . "\">";
			if ($row_numbers) {
				$out .= "\n\t\t<th>" . e($row) . "</th>";
			}
			for($col=1;$col<=$this->colcount($sheet);$col++) {
				// Account for Rowspans/Colspans
				$rowspan = $this->rowspan($row,$col,$sheet);
				$colspan = $this->colspan($row,$col,$sheet);
				for($i=0;$i<$rowspan;$i++) {
					for($j=0;$j<$colspan;$j++) {
						if (num($i)>0 || num($j)>0) {
							$this->sheets[$sheet]['cellsInfo'][num($row)+num($i)][num($col)+num($j)]['dontprint']=1;
						}
					}
				}
				if(!$this->sheets[$sheet]['cellsInfo'][$row][$col]['dontprint']) {
					$style = $this->style($row,$col,$sheet);
					if ($this->colhidden($col,$sheet)) {
						$style .= "display:none;";
					}
					$out .= "\n\t\t<td style=\"" . e($style) . "\"" . e((num($colspan) > 1?" colspan=$colspan":"")) . e((num($rowspan) > 1?" rowspan=$rowspan":"")) . ">";
					$val = $this->val($row,$col,$sheet);
					if ($val=='') { $val="&nbsp;"; }
					else { 
						$val = htmlentities($val); 
						$link = $this->hyperlink($row,$col,$sheet);
						if ($link!='') {
							$val = "<a href=\"" . e($link) . "\">" . $val . "</a>";
						}
					}
					$out .= "<nobr>".e(nl2br($val))."</nobr>";
					$out .= "</td>";
				}
			}
			$out .= "</tr>\n";
		}
		$out .= "</tbody></table>";
		return $out;
	}
	
	// --------------
	// END PUBLIC API


	var $boundsheets = array();
	var $formatRecords = array();
	var $fontRecords = array();
	var $xfRecords = array();
	var $colInfo = array();
   	var $rowInfo = array();
	
	var $sst = array();
	var $sheets = array();

	var $data;
	var $_ole;
	var $_defaultEncoding = "UTF-8";
	var $_defaultFormat = SPREADSHEET_EXCEL_READER_DEF_NUM_FORMAT;
	var $_columnsFormat = array();
	var $_rowoffset = 1;
	var $_coloffset = 1;

	/**
	 * List of default date formats used by Excel
	 */
	var $dateFormats = array (
		0xe => "m/d/Y",
		0xf => "M-d-Y",
		0x10 => "d-M",
		0x11 => "M-Y",
		0x12 => "h:i a",
		0x13 => "h:i:s a",
		0x14 => "H:i",
		0x15 => "H:i:s",
		0x16 => "d/m/Y H:i",
		0x2d => "i:s",
		0x2e => "H:i:s",
		0x2f => "i:s.S"
	);

	/**
	 * Default number formats used by Excel
	 */
	var $numberFormats = array(
		0x1 => "0",
		0x2 => "0.00",
		0x3 => "#,##0",
		0x4 => "#,##0.00",
		0x5 => "\$#,##0;(\$#,##0)",
		0x6 => "\$#,##0;[Red](\$#,##0)",
		0x7 => "\$#,##0.00;(\$#,##0.00)",
		0x8 => "\$#,##0.00;[Red](\$#,##0.00)",
		0x9 => "0%",
		0xa => "0.00%",
		0xb => "0.00E+00",
		0x25 => "#,##0;(#,##0)",
		0x26 => "#,##0;[Red](#,##0)",
		0x27 => "#,##0.00;(#,##0.00)",
		0x28 => "#,##0.00;[Red](#,##0.00)",
		0x29 => "#,##0;(#,##0)",  // Not exactly
		0x2a => "\$#,##0;(\$#,##0)",  // Not exactly
		0x2b => "#,##0.00;(#,##0.00)",  // Not exactly
		0x2c => "\$#,##0.00;(\$#,##0.00)",  // Not exactly
		0x30 => "##0.0E+0"
	);

    var $colors = Array(
        0x00 => "#000000",
        0x01 => "#FFFFFF",
        0x02 => "#FF0000",
        0x03 => "#00FF00",
        0x04 => "#0000FF",
        0x05 => "#FFFF00",
        0x06 => "#FF00FF",
        0x07 => "#00FFFF",
        0x08 => "#000000",
        0x09 => "#FFFFFF",
        0x0A => "#FF0000",
        0x0B => "#00FF00",
        0x0C => "#0000FF",
        0x0D => "#FFFF00",
        0x0E => "#FF00FF",
        0x0F => "#00FFFF",
        0x10 => "#800000",
        0x11 => "#008000",
        0x12 => "#000080",
        0x13 => "#808000",
        0x14 => "#800080",
        0x15 => "#008080",
        0x16 => "#C0C0C0",
        0x17 => "#808080",
        0x18 => "#9999FF",
        0x19 => "#993366",
        0x1A => "#FFFFCC",
        0x1B => "#CCFFFF",
        0x1C => "#660066",
        0x1D => "#FF8080",
        0x1E => "#0066CC",
        0x1F => "#CCCCFF",
        0x20 => "#000080",
        0x21 => "#FF00FF",
        0x22 => "#FFFF00",
        0x23 => "#00FFFF",
        0x24 => "#800080",
        0x25 => "#800000",
        0x26 => "#008080",
        0x27 => "#0000FF",
        0x28 => "#00CCFF",
        0x29 => "#CCFFFF",
        0x2A => "#CCFFCC",
        0x2B => "#FFFF99",
        0x2C => "#99CCFF",
        0x2D => "#FF99CC",
        0x2E => "#CC99FF",
        0x2F => "#FFCC99",
        0x30 => "#3366FF",
        0x31 => "#33CCCC",
        0x32 => "#99CC00",
        0x33 => "#FFCC00",
        0x34 => "#FF9900",
        0x35 => "#FF6600",
        0x36 => "#666699",
        0x37 => "#969696",
        0x38 => "#003366",
        0x39 => "#339966",
        0x3A => "#003300",
        0x3B => "#333300",
        0x3C => "#993300",
        0x3D => "#993366",
        0x3E => "#333399",
        0x3F => "#333333",
        0x40 => "#000000",
        0x41 => "#FFFFFF",

        0x43 => "#000000",
        0x4D => "#000000",
        0x4E => "#FFFFFF",
        0x4F => "#000000",
        0x50 => "#FFFFFF",
        0x51 => "#000000",

        0x7FFF => "#000000"
    );

	var $lineStyles = array(
		0x00 => "",
		0x01 => "Thin",
		0x02 => "Medium",
		0x03 => "Dashed",
		0x04 => "Dotted",
		0x05 => "Thick",
		0x06 => "Double",
		0x07 => "Hair",
		0x08 => "Medium dashed",
		0x09 => "Thin dash-dotted",
		0x0A => "Medium dash-dotted",
		0x0B => "Thin dash-dot-dotted",
		0x0C => "Medium dash-dot-dotted",
		0x0D => "Slanted medium dash-dotted"
	);	

	var $lineStylesCss = array(
		"Thin" => "1px solid", 
		"Medium" => "2px solid", 
		"Dashed" => "1px dashed", 
		"Dotted" => "1px dotted", 
		"Thick" => "3px solid", 
		"Double" => "double", 
		"Hair" => "1px solid", 
		"Medium dashed" => "2px dashed", 
		"Thin dash-dotted" => "1px dashed", 
		"Medium dash-dotted" => "2px dashed", 
		"Thin dash-dot-dotted" => "1px dashed", 
		"Medium dash-dot-dotted" => "2px dashed", 
		"Slanted medium dash-dotte" => "2px dashed" 
	);
	
	function read16bitstring($data, $start) {
		$len = 0;
		while (num(ord($data[num($start) + num($len)])) + num(ord($data[num($start) + num($len) + 1])) > 0) $len++;
		return substr($data, $start, $len);
	}
	
	// ADDED by Matt Kruse for better formatting
	function _format_value($format,$num,$f) {
		// 49==TEXT format
		// http://code.google.com/p/php-excel-reader/issues/detail?id=7
		if ( (!$f && $format=="%s") || (num($f)==49) || ($format=="GENERAL") ) { 
			return array('string'=>$num, 'formatColor'=>null); 
		}

		// Custom pattern can be POSITIVE;NEGATIVE;ZERO
		// The "text" option as 4th parameter is not handled
		$parts = explode(";",$format);
		$pattern = $parts[0];
		// Negative pattern
		if (cnt($parts)>2 && num($num)==0) {
			$pattern = $parts[2];
		}
		// Zero pattern
		if (cnt($parts)>1 && num($num)<0) {
			$pattern = $parts[1];
			$num = abs(num($num));
		}

		$color = "";
		$matches = array();
		$color_regex = "/^\[(BLACK|BLUE|CYAN|GREEN|MAGENTA|RED|WHITE|YELLOW)\]/i";
		if (preg_match($color_regex,$pattern,$matches)) {
			$color = strtolower($matches[1]);
			$pattern = preg_replace($color_regex,"",$pattern);
		}
		
		// In Excel formats, "_" is used to add spacing, which we can't do in HTML
		$pattern = preg_replace("/_./","",$pattern);
		
		// Some non-number characters are escaped with \, which we don't need
		$pattern = preg_replace("/\\\/","",$pattern);
		
		// Some non-number strings are quoted, so we'll get rid of the quotes
		$pattern = preg_replace("/\"/","",$pattern);

		// TEMPORARY - Convert # to 0
		$pattern = preg_replace("/\#/","0",$pattern);

		// Find out if we need comma formatting
		$has_commas = preg_match("/,/",$pattern);
		if ($has_commas) {
			$pattern = preg_replace("/,/","",$pattern);
		}

		// Handle Percentages
		if (preg_match("/\d(\%)([^\%]|$)/",$pattern,$matches)) {
			$num = num($num) * 100;
			$pattern = preg_replace("/(\d)(\%)([^\%]|$)/","$1%$3",$pattern);
		}

		// Handle the number itself
		$number_regex = "/(\d+)(\.?)(\d*)/";
		if (preg_match($number_regex,$pattern,$matches)) {
			$left = $matches[1];
			$dec = $matches[2];
			$right = $matches[3];
			if ($has_commas) {
				$formatted = number_format(num($num),strlen($right));
			}
			else {
				$sprintf_pattern = "%1.".strlen($right)."f";
				$formatted = sprintf($sprintf_pattern, $num);
			}
			$pattern = preg_replace($number_regex, $formatted, $pattern);
		}

		return array(
			'string'=>$pattern,
			'formatColor'=>$color
		);
	}

	/**
	 * Constructor
	 *
	 * Some basic initialisation
	 */
	function Spreadsheet_Excel_Reader($file='',$store_extended_info=true,$outputEncoding='') {
		$this->_ole = new OLERead();
		$this->setUTFEncoder('iconv');
		if ($outputEncoding != '') { 
			$this->setOutputEncoding($outputEncoding);
		}
		for ($i=1; num($i)<245; $i++) {
			$name = strtolower(( (num((num($i)-1))/26>=1)?chr(num((num($i)-1))/26+64):'') . chr(num((num($i)-1))%26+65));
			$this->colnames[$name] = $i;
			$this->colindexes[$i] = $name;
		}
		$this->store_extended_info = $store_extended_info;
		if ($file!="") {
			$this->read($file);
		}
	}

	/**
	 * Set the encoding method
	 */
	function setOutputEncoding($encoding) {
		$this->_defaultEncoding = $encoding;
	}

	/**
	 *  $encoder = 'iconv' or 'mb'
	 *  set iconv if you would like use 'iconv' for encode UTF-16LE to your encoding
	 *  set mb if you would like use 'mb_convert_encoding' for encode UTF-16LE to your encoding
	 */
	function setUTFEncoder($encoder = 'iconv') {
		$this->_encoderFunction = '';
		if ($encoder == 'iconv') {
			$this->_encoderFunction = function_exists('iconv') ? 'iconv' : '';
		} elseif ($encoder == 'mb') {
			$this->_encoderFunction = function_exists('mb_convert_encoding') ? 'mb_convert_encoding' : '';
		}
	}

	function setRowColOffset($iOffset) {
		$this->_rowoffset = $iOffset;
		$this->_coloffset = $iOffset;
	}

	/**
	 * Set the default number format
	 */
	function setDefaultFormat($sFormat) {
		$this->_defaultFormat = $sFormat;
	}

	/**
	 * Force a column to use a certain format
	 */
	function setColumnFormat($column, $sFormat) {
		$this->_columnsFormat[$column] = $sFormat;
	}

	/**
	 * Read the spreadsheet file using OLE, then parse
	 */
	function read($sFileName) {
		$res = $this->_ole->read($sFileName);

		// oops, something goes wrong (Darko Miljanovic)
		if($res === false) {
			// check error code
			if(num($this->_ole->error) == 1) {
				// bad file
				die('The filename ' . $sFileName . ' is not readable');
			}
			// check other error codes here (eg bad fileformat, etc...)
		}
		$this->data = $this->_ole->getWorkBook();
		$this->_parse();
	}

	/**
	 * Parse a workbook
	 *
	 * @access private
	 * @return bool
	 */
	function _parse() {
		$pos = 0;
		$data = $this->data;

		$code = v($data,$pos);
		$length = v($data,num($pos)+2);
		$version = v($data,num($pos)+4);
		$substreamType = v($data,num($pos)+6);

		$this->version = $version;

		if (($version != SPREADSHEET_EXCEL_READER_BIFF8) &&
			($version != SPREADSHEET_EXCEL_READER_BIFF7)) {
			return false;
		}

		if ($substreamType != SPREADSHEET_EXCEL_READER_WORKBOOKGLOBALS){
			return false;
		}

		$pos = num($pos) + num((num($length) + 4));

		$code = v($data,$pos);
		$length = v($data,num($pos)+2);

		while ($code != SPREADSHEET_EXCEL_READER_TYPE_EOF) {
			switch ($code) {
				case SPREADSHEET_EXCEL_READER_TYPE_SST:
					$spos = num($pos) + 4;
					$limitpos = num($spos) + num($length);
					$uniqueStrings = $this->_GetInt4d($data, num($spos)+4);
					$spos = num($spos) + num((8));
					for ($i = 0; $i < $uniqueStrings; $i++) {
						// Read in the number of characters
						if ($spos == $limitpos) {
							$opcode = v($data,$spos);
							$conlength = v($data,num($spos)+2);
							if (num($opcode) != 0x3c) {
								return -1;
							}
							$spos = num($spos) + num((4));
							$limitpos = num($spos) + num($conlength);
						}
						$numChars = ord($data[$spos]) | (ord($data[num($spos)+1]) << 8);
						$spos = num($spos) + num((2));
						$optionFlags = ord($data[$spos]);
						$spos++;
						$asciiEncoding = (num(($optionFlags & 0x01)) == 0) ;
						$extendedString = ( num(($optionFlags & 0x04)) != 0);

						// See if string contains formatting information
						$richString = ( num(($optionFlags & 0x08)) != 0);

						if ($richString) {
							// Read in the crun
							$formattingRuns = v($data,$spos);
							$spos = num($spos) + num((2));
						}

						if ($extendedString) {
							// Read in cchExtRst
							$extendedRunLength = $this->_GetInt4d($data, $spos);
							$spos = num($spos) + num((4));

						}

						$len = ($asciiEncoding)? $numChars : num($numChars)*2;
						if (num($spos) + num($len) < $limitpos) {
							$retstr = substr($data, $spos, $len);
							$spos = num($spos) + num(($len));
						}
						else{
							// found countinue
							$retstr = substr($data, $spos, num($limitpos) - num($spos));
							$bytesRead = num($limitpos) - num($spos);
							$charsLeft = num($numChars) - num((($asciiEncoding) ? $bytesRead : (num($bytesRead) / 2)));
							$spos = $limitpos;

							while (num($charsLeft) > 0){
								$opcode = v($data,$spos);
								$conlength = v($data,num($spos)+2);
								if (num($opcode) != 0x3c) {
									return -1;
								}
								$spos = num($spos) + num((4));
								$limitpos = num($spos) + num($conlength);
								$option = ord($data[$spos]);
								$spos = num($spos) + num((1));
								if ($asciiEncoding && (num($option) == 0)) {
									$len = min($charsLeft, num($limitpos) - num($spos)); // min($charsLeft, $conlength);
									$retstr .= substr($data, $spos, $len);
									$charsLeft = num($charsLeft) - num(($len));
									$asciiEncoding = true;
								}
								elseif (!$asciiEncoding && (num($option) != 0)) {
									$len = min(num($charsLeft) * 2, num($limitpos) - num($spos)); // min($charsLeft, $conlength);
									$retstr .= substr($data, $spos, $len);
									$charsLeft = num($charsLeft) - num((num($len)/2));
									$asciiEncoding = false;
								}
								elseif (!$asciiEncoding && (num($option) == 0)) {
									// Bummer - the string starts off as Unicode, but after the
									// continuation it is in straightforward ASCII encoding
									$len = min($charsLeft, num($limitpos) - num($spos)); // min($charsLeft, $conlength);
									for ($j = 0; $j < $len; $j++) {
										$retstr .= $data[num($spos) + num($j)].chr(0);
									}
									$charsLeft = num($charsLeft) - num(($len));
									$asciiEncoding = false;
								}
								else{
									$newstr = '';
									for ($j = 0; $j < strlen($retstr); $j++) {
										$newstr = $retstr[$j].chr(0);
									}
									$retstr = $newstr;
									$len = min(num($charsLeft) * 2, num($limitpos) - num($spos)); // min($charsLeft, $conlength);
									$retstr .= substr($data, $spos, $len);
									$charsLeft = num($charsLeft) - num((num($len)/2));
									$asciiEncoding = false;
								}
								$spos = num($spos) + num(($len));
							}
						}
						$retstr = ($asciiEncoding) ? $retstr : $this->_encodeUTF16($retstr);

						if ($richString){
							$spos = num($spos) + num((4 * num($formattingRuns)));
						}

						// For extended strings, skip over the extended string data
						if ($extendedString) {
							$spos = num($spos) + num(($extendedRunLength));
						}
						$this->sst[]=$retstr;
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_FILEPASS:
					return false;
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_NAME:
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_FORMAT:
					$indexCode = v($data,num($pos)+4);
					if ($version == SPREADSHEET_EXCEL_READER_BIFF8) {
						$numchars = v($data,num($pos)+6);
						if (num(ord($data[num($pos)+8])) == 0){
							$formatString = substr($data, num($pos)+9, $numchars);
						} else {
							$formatString = substr($data, num($pos)+9, num($numchars)*2);
						}
					} else {
						$numchars = ord($data[num($pos)+6]);
						$formatString = substr($data, num($pos)+7, num($numchars)*2);
					}
					$this->formatRecords[$indexCode] = $formatString;
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_FONT:
						$height = v($data,num($pos)+4);
						$option = v($data,num($pos)+6);
						$color = v($data,num($pos)+8);
						$weight = v($data,num($pos)+10);
						$under  = ord($data[num($pos)+14]);
						$font = "";
						// Font name
						$numchars = ord($data[num($pos)+18]);
						if (num((ord($data[num($pos)+19]) & 1)) == 0){
						    $font = substr($data, num($pos)+20, $numchars);
						} else {
						    $font = substr($data, num($pos)+20, num($numchars)*2);
						    $font =  $this->_encodeUTF16($font); 
						}
						$this->fontRecords[] = array(
								'height' => num($height) / 20,
								'italic' => !!($option & 2),
								'color' => $color,
								'under' => !(num($under)==0),
								'bold' => (num($weight)==700),
								'font' => $font,
								'raw' => $this->dumpHexData($data, num($pos)+3, $length)
								);
					    break;

				case SPREADSHEET_EXCEL_READER_TYPE_PALETTE:
						$colors = ord($data[num($pos)+4]) | ord($data[num($pos)+5]) << 8;
						for ($coli = 0; $coli < $colors; $coli++) {
						    $colOff = num($pos) + 2 + num((num($coli) * 4));
  						    $colr = ord($data[$colOff]);
  						    $colg = ord($data[num($colOff)+1]);
  						    $colb = ord($data[num($colOff)+2]);
							$this->colors[0x07 + num($coli)] = '#' . $this->myhex($colr) . $this->myhex($colg) . $this->myhex($colb);
						}
					    break;

				case SPREADSHEET_EXCEL_READER_TYPE_XF:
						$fontIndexCode = num((ord($data[num($pos)+4]) | ord($data[num($pos)+5]) << 8)) - 1;
						$fontIndexCode = max(0,$fontIndexCode);
						$indexCode = ord($data[num($pos)+6]) | ord($data[num($pos)+7]) << 8;
						$alignbit = ord($data[num($pos)+10]) & 3;
						$bgi = (ord($data[num($pos)+22]) | ord($data[num($pos)+23]) << 8) & 0x3FFF;
						$bgcolor = ($bgi & 0x7F);
//						$bgcolor = ($bgi & 0x3f80) >> 7;
						$align = "";
						if (num($alignbit)==3) { $align="right"; }
						if (num($alignbit)==2) { $align="center"; }

						$fillPattern = (ord($data[num($pos)+21]) & 0xFC) >> 2;
						if (num($fillPattern) == 0) {
							$bgcolor = "";
						}

						$xf = array();
						$xf['formatIndex'] = $indexCode;
						$xf['align'] = $align;
						$xf['fontIndex'] = $fontIndexCode;
						$xf['bgColor'] = $bgcolor;
						$xf['fillPattern'] = $fillPattern;

						$border = ord($data[num($pos)+14]) | (ord($data[num($pos)+15]) << 8) | (ord($data[num($pos)+16]) << 16) | (ord($data[num($pos)+17]) << 24);
						$xf['borderLeft'] = $this->lineStyles[($border & 0xF)];
						$xf['borderRight'] = $this->lineStyles[($border & 0xF0) >> 4];
						$xf['borderTop'] = $this->lineStyles[($border & 0xF00) >> 8];
						$xf['borderBottom'] = $this->lineStyles[($border & 0xF000) >> 12];
						
						$xf['borderLeftColor'] = ($border & 0x7F0000) >> 16;
						$xf['borderRightColor'] = ($border & 0x3F800000) >> 23;
						$border = (ord($data[num($pos)+18]) | ord($data[num($pos)+19]) << 8);

						$xf['borderTopColor'] = ($border & 0x7F);
						$xf['borderBottomColor'] = ($border & 0x3F80) >> 7;
												
						if (array_key_exists($indexCode, $this->dateFormats)) {
							$xf['type'] = 'date';
							$xf['format'] = $this->dateFormats[$indexCode];
							if ($align=='') { $xf['align'] = 'right'; }
						}elseif (array_key_exists($indexCode, $this->numberFormats)) {
							$xf['type'] = 'number';
							$xf['format'] = $this->numberFormats[$indexCode];
							if ($align=='') { $xf['align'] = 'right'; }
						}else{
							$isdate = FALSE;
							$formatstr = '';
							if (num($indexCode) > 0){
								if (isset($this->formatRecords[$indexCode]))
									$formatstr = $this->formatRecords[$indexCode];
								if ($formatstr!="") {
									$tmp = preg_replace("/\;.*/","",$formatstr);
									$tmp = preg_replace("/^\[[^\]]*\]/","",$tmp);
									if (num(preg_match("/[^hmsday\/\-:\s\\\,AMP]/i", $tmp)) == 0) { // found day and time format
										$isdate = TRUE;
										$formatstr = $tmp;
										$formatstr = str_replace(array('AM/PM','mmmm','mmm'), array('a','F','M'), $formatstr);
										// m/mm are used for both minutes and months - oh SNAP!
										// This mess tries to fix for that.
										// 'm' == minutes only if following h/hh or preceding s/ss
										$formatstr = preg_replace("/(h:?)mm?/","$1i", $formatstr);
										$formatstr = preg_replace("/mm?(:?s)/","i$1", $formatstr);
										// A single 'm' = n in PHP
										$formatstr = preg_replace("/(^|[^m])m([^m]|$)/", '$1n$2', $formatstr);
										$formatstr = preg_replace("/(^|[^m])m([^m]|$)/", '$1n$2', $formatstr);
										// else it's months
										$formatstr = str_replace('mm', 'm', $formatstr);
										// Convert single 'd' to 'j'
										$formatstr = preg_replace("/(^|[^d])d([^d]|$)/", '$1j$2', $formatstr);
										$formatstr = str_replace(array('dddd','ddd','dd','yyyy','yy','hh','h'), array('l','D','d','Y','y','H','g'), $formatstr);
										$formatstr = preg_replace("/ss?/", 's', $formatstr);
									}
								}
							}
							if ($isdate){
								$xf['type'] = 'date';
								$xf['format'] = $formatstr;
								if ($align=='') { $xf['align'] = 'right'; }
							}else{
								// If the format string has a 0 or # in it, we'll assume it's a number
								if (preg_match("/[0#]/", $formatstr)) {
									$xf['type'] = 'number';
									if ($align=='') { $xf['align']='right'; }
								}
								else {
								$xf['type'] = 'other';
								}
								$xf['format'] = $formatstr;
								$xf['code'] = $indexCode;
							}
						}
						$this->xfRecords[] = $xf;
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_NINETEENFOUR:
					$this->nineteenFour = (num(ord($data[num($pos)+4])) == 1);
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_BOUNDSHEET:
						$rec_offset = $this->_GetInt4d($data, num($pos)+4);
						$rec_typeFlag = ord($data[num($pos)+8]);
						$rec_visibilityFlag = ord($data[num($pos)+9]);
						$rec_length = ord($data[num($pos)+10]);

						if ($version == SPREADSHEET_EXCEL_READER_BIFF8){
							$chartype =  ord($data[num($pos)+11]);
							if (num($chartype) == 0){
								$rec_name	= substr($data, num($pos)+12, $rec_length);
							} else {
								$rec_name	= $this->_encodeUTF16(substr($data, num($pos)+12, num($rec_length)*2));
							}
						}elseif ($version == SPREADSHEET_EXCEL_READER_BIFF7){
								$rec_name	= substr($data, num($pos)+11, $rec_length);
						}
					$this->boundsheets[] = array('name'=>$rec_name,'offset'=>$rec_offset);
					break;

			}

			$pos = num($pos) + num((num($length) + 4));
			$code = ord($data[$pos]) | ord($data[num($pos)+1])<<8;
			$length = ord($data[num($pos)+2]) | ord($data[num($pos)+3])<<8;
		}

		foreach ($this->boundsheets as $key=>$val){
			$this->sn = $key;
			$this->_parsesheet($val['offset']);
		}
		return true;
	}

	/**
	 * Parse a worksheet
	 */
	function _parsesheet($spos) {
		$cont = true;
		$data = $this->data;
		// read BOF
		$code = ord($data[$spos]) | ord($data[num($spos)+1])<<8;
		$length = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;

		$version = ord($data[num($spos) + 4]) | ord($data[num($spos) + 5])<<8;
		$substreamType = ord($data[num($spos) + 6]) | ord($data[num($spos) + 7])<<8;

		if (($version != SPREADSHEET_EXCEL_READER_BIFF8) && ($version != SPREADSHEET_EXCEL_READER_BIFF7)) {
			return -1;
		}

		if ($substreamType != SPREADSHEET_EXCEL_READER_WORKSHEET){
			return -2;
		}
		$spos = num($spos) + num((num($length) + 4));
		while($cont) {
			$lowcode = ord($data[$spos]);
			if ($lowcode == SPREADSHEET_EXCEL_READER_TYPE_EOF) break;
			$code = $lowcode | ord($data[num($spos)+1])<<8;
			$length = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
			$spos = num($spos) + num((4));
			$this->sheets[$this->sn]['maxrow'] = num($this->_rowoffset) - 1;
			$this->sheets[$this->sn]['maxcol'] = num($this->_coloffset) - 1;
			unset($this->rectype);
			switch ($code) {
				case SPREADSHEET_EXCEL_READER_TYPE_DIMENSION:
					if (!isset($this->numRows)) {
						if ((num($length) == 10) ||  ($version == SPREADSHEET_EXCEL_READER_BIFF7)){
							$this->sheets[$this->sn]['numRows'] = ord($data[num($spos)+2]) | ord($data[num($spos)+3]) << 8;
							$this->sheets[$this->sn]['numCols'] = ord($data[num($spos)+6]) | ord($data[num($spos)+7]) << 8;
						} else {
							$this->sheets[$this->sn]['numRows'] = ord($data[num($spos)+4]) | ord($data[num($spos)+5]) << 8;
							$this->sheets[$this->sn]['numCols'] = ord($data[num($spos)+10]) | ord($data[num($spos)+11]) << 8;
						}
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_MERGEDCELLS:
					$cellRanges = ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					for ($i = 0; $i < $cellRanges; $i++) {
						$fr =  ord($data[num($spos) + 8*num($i) + 2]) | ord($data[num($spos) + 8*num($i) + 3])<<8;
						$lr =  ord($data[num($spos) + 8*num($i) + 4]) | ord($data[num($spos) + 8*num($i) + 5])<<8;
						$fc =  ord($data[num($spos) + 8*num($i) + 6]) | ord($data[num($spos) + 8*num($i) + 7])<<8;
						$lc =  ord($data[num($spos) + 8*num($i) + 8]) | ord($data[num($spos) + 8*num($i) + 9])<<8;
						if (num($lr) - num($fr) > 0) {
							$this->sheets[$this->sn]['cellsInfo'][num($fr)+1][num($fc)+1]['rowspan'] = num($lr) - num($fr) + 1;
						}
						if (num($lc) - num($fc) > 0) {
							$this->sheets[$this->sn]['cellsInfo'][num($fr)+1][num($fc)+1]['colspan'] = num($lc) - num($fc) + 1;
						}
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_RK:
				case SPREADSHEET_EXCEL_READER_TYPE_RK2:
					$row = ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$rknum = $this->_GetInt4d($data, num($spos) + 6);
					$numValue = $this->_GetIEEE754($rknum);
					$info = $this->_getCellDetails($spos,$numValue,$column);
					$this->addcell($row, $column, $info['string'],$info);
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_LABELSST:
					$row		= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column	 = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$xfindex	= ord($data[num($spos)+4]) | ord($data[num($spos)+5])<<8;
					$index  = $this->_GetInt4d($data, num($spos) + 6);
					$this->addcell($row, $column, $this->sst[$index], array('xfIndex'=>$xfindex) );
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_MULRK:
					$row		= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$colFirst   = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$colLast	= ord($data[num($spos) + num($length) - 2]) | ord($data[num($spos) + num($length) - 1])<<8;
					$columns	= num($colLast) - num($colFirst) + 1;
					$tmppos = num($spos)+4;
					for ($i = 0; $i < $columns; $i++) {
						$numValue = $this->_GetIEEE754($this->_GetInt4d($data, num($tmppos) + 2));
						$info = $this->_getCellDetails(num($tmppos)-4,$numValue,num($colFirst) + num($i) + 1);
						$tmppos = num($tmppos) + num((6));
						$this->addcell($row, num($colFirst) + num($i), $info['string'], $info);
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_NUMBER:
					$row	= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$tmp = unpack("ddouble", substr($data, num($spos) + 6, 8)); // It machine machine dependent
					if ($this->isDate($spos)) {
						$numValue = $tmp['double'];
					}
					else {
						$numValue = $this->createNumber($spos);
					}
					$info = $this->_getCellDetails($spos,$numValue,$column);
					$this->addcell($row, $column, $info['string'], $info);
					break;

				case SPREADSHEET_EXCEL_READER_TYPE_FORMULA:
				case SPREADSHEET_EXCEL_READER_TYPE_FORMULA2:
					$row	= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					if ((num(ord($data[num($spos)+6]))==0) && (num(ord($data[num($spos)+12]))==255) && (num(ord($data[num($spos)+13]))==255)) {
						//String formula. Result follows in a STRING record
						// This row/col are stored to be referenced in that record
						// http://code.google.com/p/php-excel-reader/issues/detail?id=4
						$previousRow = $row;
						$previousCol = $column;
					} elseif ((num(ord($data[num($spos)+6]))==1) && (num(ord($data[num($spos)+12]))==255) && (num(ord($data[num($spos)+13]))==255)) {
						//Boolean formula. Result is in +2; 0=false,1=true
						// http://code.google.com/p/php-excel-reader/issues/detail?id=4
                        if (num(ord($this->data[num($spos)+8]))==1) {
                            $this->addcell($row, $column, "TRUE");
                        } else {
                            $this->addcell($row, $column, "FALSE");
                        }
					} elseif ((num(ord($data[num($spos)+6]))==2) && (num(ord($data[num($spos)+12]))==255) && (num(ord($data[num($spos)+13]))==255)) {
						//Error formula. Error code is in +2;
					} elseif ((num(ord($data[num($spos)+6]))==3) && (num(ord($data[num($spos)+12]))==255) && (num(ord($data[num($spos)+13]))==255)) {
						//Formula result is a null string.
						$this->addcell($row, $column, '');
					} else {
						// result is a number, so first 14 bytes are just like a _NUMBER record
						$tmp = unpack("ddouble", substr($data, num($spos) + 6, 8)); // It machine machine dependent
							  if ($this->isDate($spos)) {
								$numValue = $tmp['double'];
							  }
							  else {
								$numValue = $this->createNumber($spos);
							  }
						$info = $this->_getCellDetails($spos,$numValue,$column);
						$this->addcell($row, $column, $info['string'], $info);
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_BOOLERR:
					$row	= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$string = ord($data[num($spos)+6]);
					$this->addcell($row, $column, $string);
					break;
                case SPREADSHEET_EXCEL_READER_TYPE_STRING:
					// http://code.google.com/p/php-excel-reader/issues/detail?id=4
					if ($version == SPREADSHEET_EXCEL_READER_BIFF8){
						// Unicode 16 string, like an SST record
						$xpos = $spos;
						$numChars =ord($data[$xpos]) | (ord($data[num($xpos)+1]) << 8);
						$xpos = num($xpos) + num((2));
						$optionFlags =ord($data[$xpos]);
						$xpos++;
						$asciiEncoding = (num(($optionFlags &0x01)) == 0) ;
						$extendedString = (num(($optionFlags & 0x04)) != 0);
                        // See if string contains formatting information
						$richString = (num(($optionFlags & 0x08)) != 0);
						if ($richString) {
							// Read in the crun
							$formattingRuns =ord($data[$xpos]) | (ord($data[num($xpos)+1]) << 8);
							$xpos = num($xpos) + num((2));
						}
						if ($extendedString) {
							// Read in cchExtRst
							$extendedRunLength =$this->_GetInt4d($this->data, $xpos);
							$xpos = num($xpos) + num((4));
						}
						$len = ($asciiEncoding)?$numChars : num($numChars)*2;
						$retstr =substr($data, $xpos, $len);
						$xpos = num($xpos) + num(($len));
						$retstr = ($asciiEncoding)? $retstr : $this->_encodeUTF16($retstr);
					}
					elseif ($version == SPREADSHEET_EXCEL_READER_BIFF7){
						// Simple byte string
						$xpos = $spos;
						$numChars =ord($data[$xpos]) | (ord($data[num($xpos)+1]) << 8);
						$xpos = num($xpos) + num((2));
						$retstr =substr($data, $xpos, $numChars);
					}
					$this->addcell($previousRow, $previousCol, $retstr);
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_ROW:
					$row	= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$rowInfo = ord($data[num($spos) + 6]) | ((ord($data[num($spos)+7]) << 8) & 0x7FFF);
					if (num(($rowInfo & 0x8000)) > 0) {
						$rowHeight = -1;
					} else {
						$rowHeight = $rowInfo & 0x7FFF;
					}
					$rowHidden = (ord($data[num($spos) + 12]) & 0x20) >> 5;
					$this->rowInfo[$this->sn][num($row)+1] = Array('height' => num($rowHeight) / 20, 'hidden'=>$rowHidden );
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_DBCELL:
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_MULBLANK:
					$row = ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$cols = num((num($length) / 2)) - 3;
					for ($c = 0; $c < $cols; $c++) {
						$xfindex = ord($data[num($spos) + 4 + num((num($c) * 2))]) | ord($data[num($spos) + 5 + num((num($c) * 2))])<<8;
						$this->addcell($row, num($column) + num($c), "", array('xfIndex'=>$xfindex));
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_LABEL:
					$row	= ord($data[$spos]) | ord($data[num($spos)+1])<<8;
					$column = ord($data[num($spos)+2]) | ord($data[num($spos)+3])<<8;
					$this->addcell($row, $column, substr($data, num($spos) + 8, ord($data[num($spos) + 6]) | ord($data[num($spos) + 7])<<8));
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_EOF:
					$cont = false;
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_HYPER:
					//  Only handle hyperlinks to a URL
					$row	= ord($this->data[$spos]) | ord($this->data[num($spos)+1])<<8;
					$row2   = ord($this->data[num($spos)+2]) | ord($this->data[num($spos)+3])<<8;
					$column = ord($this->data[num($spos)+4]) | ord($this->data[num($spos)+5])<<8;
					$column2 = ord($this->data[num($spos)+6]) | ord($this->data[num($spos)+7])<<8;
					$linkdata = Array();
					$flags = ord($this->data[num($spos) + 28]);
					$udesc = "";
					$ulink = "";
					$uloc = 32;
					$linkdata['flags'] = $flags;
					if (num(($flags & 1)) > 0 ) {   // is a type we understand
						//  is there a description ?
						if (num(($flags & 0x14)) == 0x14 ) {   // has a description
							$uloc = num($uloc) + num((4));
							$descLen = ord($this->data[num($spos) + 32]) | ord($this->data[num($spos) + 33]) << 8;
							$udesc = substr($this->data, num($spos) + num($uloc), num($descLen) * 2);
							$uloc = num($uloc) + num((2 * num($descLen)));
						}
						$ulink = $this->read16bitstring($this->data, num($spos) + num($uloc) + 20);
						if ($udesc == "") {
							$udesc = $ulink;
						}
					}
					$linkdata['desc'] = $udesc;
					$linkdata['link'] = $this->_encodeUTF16($ulink);
					for ($r=$row; $r<=$row2; $r++) { 
						for ($c=$column; $c<=$column2; $c++) {
							$this->sheets[$this->sn]['cellsInfo'][num($r)+1][num($c)+1]['hyperlink'] = $linkdata;
						}
					}
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_DEFCOLWIDTH:
					$this->defaultColWidth  = ord($data[num($spos)+4]) | ord($data[num($spos)+5]) << 8; 
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_STANDARDWIDTH:
					$this->standardColWidth  = ord($data[num($spos)+4]) | ord($data[num($spos)+5]) << 8; 
					break;
				case SPREADSHEET_EXCEL_READER_TYPE_COLINFO:
					$colfrom = ord($data[num($spos)+0]) | ord($data[num($spos)+1]) << 8;
					$colto = ord($data[num($spos)+2]) | ord($data[num($spos)+3]) << 8;
					$cw = ord($data[num($spos)+4]) | ord($data[num($spos)+5]) << 8; 
					$cxf = ord($data[num($spos)+6]) | ord($data[num($spos)+7]) << 8; 
					$co = ord($data[num($spos)+8]); 
					for ($coli = $colfrom; $coli <= $colto; $coli++) {
						$this->colInfo[$this->sn][num($coli)+1] = Array('width' => $cw, 'xf' => $cxf, 'hidden' => ($co & 0x01), 'collapsed' => ($co & 0x1000) >> 12);
					}
					break;

				default:
					break;
			}
			$spos = num($spos) + num(($length));
		}

		if (!isset($this->sheets[$this->sn]['numRows']))
			 $this->sheets[$this->sn]['numRows'] = $this->sheets[$this->sn]['maxrow'];
		if (!isset($this->sheets[$this->sn]['numCols']))
			 $this->sheets[$this->sn]['numCols'] = $this->sheets[$this->sn]['maxcol'];
		}

		function isDate($spos) {
			$xfindex = ord($this->data[num($spos)+4]) | ord($this->data[num($spos)+5]) << 8;
			return ($this->xfRecords[$xfindex]['type'] == 'date');
		}

		// Get the details for a particular cell
		function _getCellDetails($spos,$numValue,$column) {
			$xfindex = ord($this->data[num($spos)+4]) | ord($this->data[num($spos)+5]) << 8;
			$xfrecord = $this->xfRecords[$xfindex];
			$type = $xfrecord['type'];

			$format = $xfrecord['format'];
			$formatIndex = $xfrecord['formatIndex'];
			$fontIndex = $xfrecord['fontIndex'];
			$formatColor = "";
			$rectype = '';
			$string = '';
			$raw = '';

			if (isset($this->_columnsFormat[num($column) + 1])){
				$format = $this->_columnsFormat[num($column) + 1];
			}

			if ($type == 'date') {
				// See http://groups.google.com/group/php-excel-reader-discuss/browse_frm/thread/9c3f9790d12d8e10/f2045c2369ac79de
				$rectype = 'date';
				// Convert numeric value into a date
				$utcDays = floor(num($numValue) - num(($this->nineteenFour ? SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904 : SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS)));
				$utcValue = num(($utcDays)) * num(SPREADSHEET_EXCEL_READER_MSINADAY);
				$dateinfo = gmgetdate($utcValue);

				$raw = $numValue;
				$fractionalDay = num($numValue) - floor(num($numValue)) + .0000001; // The .0000001 is to fix for php/excel fractional diffs

				$totalseconds = floor(num(SPREADSHEET_EXCEL_READER_MSINADAY) * num($fractionalDay));
				$secs = num($totalseconds) % 60;
				$totalseconds = num($totalseconds) - num(($secs));
				$hours = floor(div($totalseconds, (60 * 60)));
				$mins = floor(num($totalseconds) / 60) % 60;
				$string = date ($format, mktime($hours, $mins, $secs, $dateinfo["mon"], $dateinfo["mday"], $dateinfo["year"]));
			} else if ($type == 'number') {
				$rectype = 'number';
				$formatted = $this->_format_value($format, $numValue, $formatIndex);
				$string = $formatted['string'];
				$formatColor = $formatted['formatColor'];
				$raw = $numValue;
			} else{
				if ($format=="") {
					$format = $this->_defaultFormat;
				}
				$rectype = 'unknown';
				$formatted = $this->_format_value($format, $numValue, $formatIndex);
				$string = $formatted['string'];
				$formatColor = $formatted['formatColor'];
				$raw = $numValue;
			}

			return array(
				'string'=>$string,
				'raw'=>$raw,
				'rectype'=>$rectype,
				'format'=>$format,
				'formatIndex'=>$formatIndex,
				'fontIndex'=>$fontIndex,
				'formatColor'=>$formatColor,
				'xfIndex'=>$xfindex
			);

		}


	function createNumber($spos) {
		$rknumhigh = $this->_GetInt4d($this->data, num($spos) + 10);
		$rknumlow = $this->_GetInt4d($this->data, num($spos) + 6);
		$sign = ($rknumhigh & 0x80000000) >> 31;
		$exp =  ($rknumhigh & 0x7ff00000) >> 20;
		$mantissa = (0x100000 | ($rknumhigh & 0x000fffff));
		$mantissalow1 = ($rknumlow & 0x80000000) >> 31;
		$mantissalow2 = ($rknumlow & 0x7fffffff);
		$value = div($mantissa, pow( 2 , (20- num((num($exp) - 1023)))));
		if (num($mantissalow1) != 0) $value = num($value) + num((div(1, pow (2 , (21 - num((num($exp) - 1023)))))));
		$value = num($value) + num((div($mantissalow2, pow (2 , (52 - num((num($exp) - 1023)))))));
		if ($sign) {$value = -1 * num($value);}
		return  $value;
	}

	function addcell($row, $col, $string, $info=null) {
		$this->sheets[$this->sn]['maxrow'] = max($this->sheets[$this->sn]['maxrow'], num($row) + num($this->_rowoffset));
		$this->sheets[$this->sn]['maxcol'] = max($this->sheets[$this->sn]['maxcol'], num($col) + num($this->_coloffset));
		$this->sheets[$this->sn]['cells'][num($row) + num($this->_rowoffset)][num($col) + num($this->_coloffset)] = $string;
		if ($this->store_extended_info && $info) {
			foreach ($info as $key=>$val) {
				$this->sheets[$this->sn]['cellsInfo'][num($row) + num($this->_rowoffset)][num($col) + num($this->_coloffset)][$key] = $val;
			}
		}
	}


	function _GetIEEE754($rknum) {
		if (num(($rknum & 0x02)) != 0) {
				$value = $rknum >> 2;
		} else {
			//mmp
			// I got my info on IEEE754 encoding from
			// http://research.microsoft.com/~hollasch/cgindex/coding/ieeefloat.html
			// The RK format calls for using only the most significant 30 bits of the
			// 64 bit floating point value. The other 34 bits are assumed to be 0
			// So, we use the upper 30 bits of $rknum as follows...
			$sign = ($rknum & 0x80000000) >> 31;
			$exp = ($rknum & 0x7ff00000) >> 20;
			$mantissa = (0x100000 | ($rknum & 0x000ffffc));
			$value = div($mantissa, pow( 2 , (20- num((num($exp) - 1023)))));
			if ($sign) {
				$value = -1 * num($value);
			}
			//end of changes by mmp
		}
		if (num(($rknum & 0x01)) != 0) {
			$value = div($value, (100));
		}
		return $value;
	}

	function _encodeUTF16($string) {
		$result = $string;
		if ($this->_defaultEncoding){
			switch ($this->_encoderFunction){
				case 'iconv' :	 $result = iconv('UTF-16LE', $this->_defaultEncoding, $string);
								break;
				case 'mb_convert_encoding' :	 $result = mb_convert_encoding($string, $this->_defaultEncoding, 'UTF-16LE' );
								break;
			}
		}
		return $result;
	}

	function _GetInt4d($data, $pos) {
		$value = ord($data[$pos]) | (ord($data[num($pos)+1]) << 8) | (ord($data[num($pos)+2]) << 16) | (ord($data[num($pos)+3]) << 24);
		if (num($value)>=4294967294) {
			$value=-2;
		}
		return $value;
	}

}

?>