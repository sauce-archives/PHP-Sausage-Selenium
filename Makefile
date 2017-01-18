run_all_in_parallel:
	make -j OSX_10_chrome45 magento_registration

OSX_10_chrome45:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/example_spec.php

magento_registration:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/magento_registration.php
