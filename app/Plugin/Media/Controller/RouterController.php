<?
App::uses('AppController', 'Controller');
class RouterController extends AppController {
	var $name = 'Router';
	var $layout = false;
	var $uses = false;
	var $autoRender = false;

	public function beforeFilter() {
		$this->Auth->allow('index');
	}
	
	public function beforeRender() {
	}
	
	public function index($type, $id, $size, $filename) {
		App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();
		
		$aFName = $this->PHMedia->getFileInfo($filename);
		$fname = $this->PHMedia->getFileName($type, $id, $size, $filename);

		if (file_exists($fname) && filesize($fname)) {
			header('Content-type: image/'.$aFName['ext']);
			echo file_get_contents($fname);
			exit;
		}
		
		App::uses('Image', 'Media.Vendor');
		$image = new Image();
		
		$aSize = $this->PHMedia->getSizeInfo($size);
		$method = $this->PHMedia->getResizeMethod($size);
		$origImg = $this->PHMedia->getFileName($type, $id, null, $aFName['fname'].'.'.$aFName['orig_ext']);
		if ($method == 'thumb') {
			$thumb = $this->PHMedia->getFileName($type, $id, null, 'thumb.png');
			if (file_exists($thumb)) {
				$origImg = $thumb;
			}
		}
		
		$image->load($origImg);
		if ($aSize) {
			$method = $this->PHMedia->getResizeMethod($size);
			$image->{$method}($aSize['w'], $aSize['h']);
		}
		
		if ($type == 'product' || $type == 'news') {

			$logo = new Image();
			$logo->load('./img/wlogo.gif');

			if ($image->getSizeX() > 1200 || $image->getSizeY() > 900) {
				$image->resize(1200, null);
			}

			if ($image->getSizeX() <= 400 || $image->getSizeY() <= 250) {
				$logo->resize(150, null);
			}

			imagealphablending($image->getImage(), false);
			imagesavealpha($image->getImage(), true);

			if ($logo->getSizeX() < $image->getSizeX() && $logo->getSizeY() < $image->getSizeY()) {
				imagecopymerge($image->getImage(), $logo->getImage(),
					$image->getSizeX() - $logo->getSizeX(), $image->getSizeY() - $logo->getSizeY(),
					0, 0, $logo->getSizeX(), $logo->getSizeY(),
					40
				);
			} else {
				$oldSizeX = $image->getSizeX();

				// т.к. есть баг с ресайзом лого (при ресайзе исчезает прозрачность и появляется фон),
				// то ресайзим саму картинку, а потом возвращаем ее в исх. размер
				$image->resize($logo->getSizeX(), null); // по идее все картинки по ширине больше чем по высоте

				$x = round(($image->getSizeX()) / 2, 0) - round($logo->getSizeX() / 2, 0);
				$y = round(($image->getSizeY()) / 2, 0) - round($logo->getSizeY() / 2, 0);
				imagecopymerge($image->getImage(), $logo->getImage(), $x, $y, 0, 0, $logo->getSizeX(), $logo->getSizeY(), 40);

				$image->resize($oldSizeX, null);
			}
		}

		if ($aFName['ext'] == 'jpg') {
			$image->outputJpg($fname);
			$image->outputJpg();
		} elseif ($aFName['ext'] == 'png') {
			$image->outputPng($fname);
			$image->outputPng();
		} else {
			$image->outputGif($fname);
			$image->outputGif();
		}
		exit;
	}
	
}
