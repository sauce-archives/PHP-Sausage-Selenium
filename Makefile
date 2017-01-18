run_all_in_parallel:
	make -j magento_cart magento_registration

magento_cart:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/magento_cart.php

magento_registration:
	vendor/bin/paratest -p 4 -f --phpunit=vendor/bin/phpunit tests/magento_registration.php