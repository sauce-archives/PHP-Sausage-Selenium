run_all_in_parallel:
	make -j Windows7_firefox35 OSX_10_chrome45 magento_registration

OSX_10_chrome45:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/example_spec.php

Windows7_firefox35:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/example_spec2.php

magento_registration:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/magento_registration.php
