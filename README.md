# AARFix

This is a php script that modifies an .aar file to work around this error:

~~~~
$ adb install TestNatives-release.apk 
adb: failed to install TestNatives-release.apk: Failure [INSTALL_FAILED_NO_MATCHING_ABIS: Failed to extract native libraries, res=-113]
~~~~

See [this issue](https://github.com/codenameone/CodenameOne/issues/2917) for the motivation.

It will find all .so files in the .aar file, and make dummy .so files for any ABI that is missing.

## Usage

First you need to modify the aarfix.php script to choose the target ABIs.  These are the only ABIs
for which you will generate dummy .so files.    You can do this by modifying the following line 
in the aarfix.php file:

~~~~
const TARGET_ABIS = array('armeabi-v7a', 'arm64-v8a', 'x86', 'x86_64');
~~~~

Select only platforms for which you want to generate dummy .so files.

Then run the php script as follows:

~~~~
$ php /path/to/aarfix.php /path/to/mylib.aar
~~~~

Example run output:

~~~~

$ php ~/aarfix/aarfix.php TPSLibrary.aar 
Archive:  TPSLibrary.aar
  inflating: AndroidManifest.xml     
  inflating: R.txt                   
  inflating: classes.jar             
   creating: jni/
   creating: jni/armeabi/
  inflating: jni/armeabi/libcard_reader.so  
  inflating: jni/armeabi/libcollect.so  
  inflating: jni/armeabi/libdecode.so  
  inflating: jni/armeabi/libidcard.so  
  inflating: jni/armeabi/libled.so   
  inflating: jni/armeabi/libledpower.so  
  inflating: jni/armeabi/libmoneybox.so  
  inflating: jni/armeabi/libpicc.so  
  inflating: jni/armeabi/libposutil.so  
  inflating: jni/armeabi/libserial_port.so  
  inflating: jni/armeabi/libsystem_util.so  
  inflating: jni/armeabi/libtelpo_msr.so  
  inflating: jni/armeabi/libtelpo_printer.so  
  inflating: jni/armeabi/libtelpo_serial.so  
  inflating: jni/armeabi/libusb_util.so  
   creating: libs/
  inflating: libs/core-3.1.0.jar     
  inflating: libs/SmartCardLib.jar   
  inflating: libs/telpo_api.jar      
   creating: armeabi/
Adding dummy .so file at ./jni/x86_64/libcard_reader.so.
Adding dummy .so file at ./jni/x86_64/libcollect.so.
Adding dummy .so file at ./jni/x86_64/libdecode.so.
Adding dummy .so file at ./jni/x86_64/libidcard.so.
Adding dummy .so file at ./jni/x86_64/libled.so.
Adding dummy .so file at ./jni/x86_64/libledpower.so.
Adding dummy .so file at ./jni/x86_64/libmoneybox.so.
Adding dummy .so file at ./jni/x86_64/libpicc.so.
Adding dummy .so file at ./jni/x86_64/libposutil.so.
Adding dummy .so file at ./jni/x86_64/libserial_port.so.
Adding dummy .so file at ./jni/x86_64/libsystem_util.so.
Adding dummy .so file at ./jni/x86_64/libtelpo_msr.so.
Adding dummy .so file at ./jni/x86_64/libtelpo_printer.so.
Adding dummy .so file at ./jni/x86_64/libtelpo_serial.so.
Adding dummy .so file at ./jni/x86_64/libusb_util.so.
  adding: AndroidManifest.xml (deflated 41%)
  adding: R.txt (deflated 82%)
  adding: armeabi/ (stored 0%)
  adding: classes.jar (deflated 10%)
  adding: jni/ (stored 0%)
  adding: jni/armeabi/ (stored 0%)
  adding: jni/armeabi/libcard_reader.so (deflated 51%)
  adding: jni/armeabi/libcollect.so (deflated 59%)
  adding: jni/armeabi/libdecode.so (deflated 56%)
  adding: jni/armeabi/libidcard.so (deflated 54%)
  adding: jni/armeabi/libled.so (deflated 59%)
  adding: jni/armeabi/libledpower.so (deflated 56%)
  adding: jni/armeabi/libmoneybox.so (deflated 58%)
  adding: jni/armeabi/libpicc.so (deflated 54%)
  adding: jni/armeabi/libposutil.so (deflated 60%)
  adding: jni/armeabi/libserial_port.so (deflated 46%)
  adding: jni/armeabi/libsystem_util.so (deflated 59%)
  adding: jni/armeabi/libtelpo_msr.so (deflated 50%)
  adding: jni/armeabi/libtelpo_printer.so (deflated 53%)
  adding: jni/armeabi/libtelpo_serial.so (deflated 55%)
  adding: jni/armeabi/libusb_util.so (deflated 51%)
  adding: jni/x86_64/ (stored 0%)
  adding: jni/x86_64/libcard_reader.so (deflated 67%)
  adding: jni/x86_64/libcollect.so (deflated 67%)
  adding: jni/x86_64/libdecode.so (deflated 67%)
  adding: jni/x86_64/libidcard.so (deflated 67%)
  adding: jni/x86_64/libled.so (deflated 67%)
  adding: jni/x86_64/libledpower.so (deflated 67%)
  adding: jni/x86_64/libmoneybox.so (deflated 67%)
  adding: jni/x86_64/libpicc.so (deflated 67%)
  adding: jni/x86_64/libposutil.so (deflated 67%)
  adding: jni/x86_64/libserial_port.so (deflated 67%)
  adding: jni/x86_64/libsystem_util.so (deflated 67%)
  adding: jni/x86_64/libtelpo_msr.so (deflated 67%)
  adding: jni/x86_64/libtelpo_printer.so (deflated 67%)
  adding: jni/x86_64/libtelpo_serial.so (deflated 67%)
  adding: jni/x86_64/libusb_util.so (deflated 67%)
  adding: libs/ (stored 0%)
  adding: libs/core-3.1.0.jar (deflated 9%)
  adding: libs/SmartCardLib.jar (deflated 5%)
  adding: libs/telpo_api.jar (deflated 8%)
Successfully fixed TPSLibrary.aar
Contents are now: 
   315 Fri Feb 01 00:00:00 PST 1980 AndroidManifest.xml
 77411 Fri Feb 01 00:00:00 PST 1980 R.txt
     0 Fri Feb 01 00:00:00 PST 1980 armeabi/
   680 Fri Feb 01 00:00:00 PST 1980 classes.jar
     0 Wed Sep 18 13:26:06 PDT 2019 jni/
     0 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/
 59928 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libcard_reader.so
 17528 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libcollect.so
 29828 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libdecode.so
142392 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libidcard.so
 13432 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libled.so
 25720 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libledpower.so
 33912 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libmoneybox.so
 46204 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libpicc.so
 21916 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libposutil.so
 12176 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libserial_port.so
 21624 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libsystem_util.so
 42188 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libtelpo_msr.so
 99524 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libtelpo_printer.so
 25720 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libtelpo_serial.so
 21688 Fri Feb 01 00:00:00 PST 1980 jni/armeabi/libusb_util.so
     0 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libcard_reader.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libcollect.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libdecode.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libidcard.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libled.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libledpower.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libmoneybox.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libpicc.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libposutil.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libserial_port.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libsystem_util.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libtelpo_msr.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libtelpo_printer.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libtelpo_serial.so
 25208 Wed Sep 18 13:26:06 PDT 2019 jni/x86_64/libusb_util.so
     0 Fri Feb 01 00:00:00 PST 1980 libs/
593635 Fri Feb 01 00:00:00 PST 1980 libs/core-3.1.0.jar
 39098 Fri Feb 01 00:00:00 PST 1980 libs/SmartCardLib.jar
183611 Fri Feb 01 00:00:00 PST 1980 libs/telpo_api.jar
~~~~
