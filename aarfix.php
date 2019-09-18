<?php
/**
 * A PHP script that will generate dummy native .so files for one or more ABIs
 * in a .aar file so that it can be installed in 64 bit devices on Android 9.
 * This was created as a proof of concept for overcoming bugs like:
 * https://github.com/codenameone/CodenameOne/issues/2917
 *
 * Setup: change the TARGET_ABIS constant in this file to reflect the ABIs that
 * you wish to generate stubs for.  If the aar includes .
 * Usage: php /path/to/aarfix.php /path/to/mylib.aar
 *
 * Created by Steve Hannah <steve.hannah@codenameone.com>
 */
 
ini_set('display_errors', 'on');
class AARLibrary {
	private $path;
	const TARGET_ABIS = array('armeabi-v7a', 'arm64-v8a', 'x86', 'x86_64');
	public function __construct($path) {
		$this->path = $path;
	}
	
	public function fix() {
		if (!file_exists($this->path)) {
			fwrite(STDERR, "ERROR: File ".$this->path." not found\n");
			exit(1);
		}
	
		$dir = getcwd();
		$aarPath = realpath($this->path);
		chdir(dirname($aarPath));
		mkdir($aarPath . '.tmp');
		chdir($aarPath . '.tmp');
		if (!copy($aarPath, basename($aarPath))) {
			fwrite(STDERR, "Failed to copy $aarPath to ".getcwd()."\n");
			exit(1);
		}
		passthru("unzip ".escapeshellarg(basename($aarPath)), $res);
		if ($res !== 0) {
			fwrite(STDERR, "ERROR: Failed to extract aar\n");
			exit(1);
		}
		
		exec("find . -name *.so", $buffer, $res);
		if ($res !== 0) {
			fwrite(STDERR, "Error:  Failed to find .so files\n");
			exit(1);
		}
		foreach ($buffer as $line) {
			$this->copySOFile($line);
		}

		unlink(basename($aarPath));
		passthru("zip -r ".escapeshellarg(basename($aarPath))." *", $res);
		if ($res !== 0) {
			fwrite(STDERR, "ERROR: Failed to zip modified aar file.\n");
			exit(1);
		}
		$res = copy(basename($aarPath), $aarPath);
		if (!$res) {
			fwrite(STDERR, "ERROR: Failed to copy modified aar file to its final location\n");
			exit(1);
		}
		chdir("..");
		passthru("rm -rf ".escapeshellarg(basename($aarPath).'.tmp'), $res);
		if ($res !== 0) {
			fwrite(STDERR, "ERROR: Failed to remove tmp directory.\n");
			exit(1);
		}
		echo "Successfully fixed ".$this->path."\n";
		echo "Contents are now: \n";
		passthru("jar tvf ".escapeshellarg($this->path)."\n");
		
	}
	
	private function getDummyFile($abi) {
		return dirname(__FILE__). DIRECTORY_SEPARATOR . $abi . '.so';
	}
	
	private function copySOFile($path) {
		$fileName = basename($path);
		$abi = basename(dirname($fileName));
		//$targets = array('armeabi-v7a', 'arm64-v8a', 'x86', 'x86_64');
		$targets = self::TARGET_ABIS;
		foreach ($targets as $target) {
			if ($target == $abi) {
				continue;
			}
			$targetPath = dirname(dirname($path)).DIRECTORY_SEPARATOR.$target.DIRECTORY_SEPARATOR.$fileName;
			echo "Adding dummy .so file at $targetPath.\n";
			@mkdir(dirname($targetPath));
			if (!copy($this->getDummyFile($target), $targetPath)) {
				fwrite(STDERR, "Failed to copy dummy file to $targetPath\n");
				exit(1);
			}
		}
		
	}
}

if (!@$argv) {
	fwrite(STDERR, "ERROR: Must run in CLI mode\n");
	exit(1);
}
if (count($argv) < 2) {
	fwrite(STDERR, "Usage: php aarfix.php path/to/mylib.aar\n");
	exit(1);
}

$lib = new AARLibrary($argv[1]);
$lib->fix();

