run_all_in_parallel:
	make -j magento_registration

magento_registration:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/magento_registration.php
