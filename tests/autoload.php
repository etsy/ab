<?php
require dirname(__DIR__) . '/Etsy/AB2/autoload.php';

spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'etsy_ab2_logger_multiloggertest' => '/Logger/MultiLoggerTest.php',
            'etsy_ab2_logger_testvarmaptest' => '/Logger/TestVarMapTest.php',
            'etsy_ab2_logger_uniqueentriestest' => '/Logger/UniqueEntriesTest.php',
            'etsy_ab2_selector_fixedtest' => '/Selector/FixedTest.php',
            'etsy_ab2_selector_hashrandomizertest' => '/Selector/HashRandomizerTest.php',
            'etsy_ab2_selector_randomtest' => '/Selector/RandomTest.php',
            'etsy_ab2_selector_sequencetest' => '/Selector/SequenceTest.php',
            'etsy_ab2_selector_weightedtest' => '/Selector/WeightedTest.php',
            'etsy_ab2_testtest' => '/TestTest.php',
            'etsy_ab2_varianttest' => '/VariantTest.php',
            'etsy_ab2_variantutilstest' => '/VariantUtilsTest.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);
