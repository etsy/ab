<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'etsy_ab2_logger' => '/Logger.php',
            'etsy_ab2_logger_multilogger' => '/Logger/MultiLogger.php',
            'etsy_ab2_logger_testvarmap' => '/Logger/TestVarMap.php',
            'etsy_ab2_logger_uniqueentries' => '/Logger/UniqueEntries.php',
            'etsy_ab2_selector' => '/Selector.php',
            'etsy_ab2_selector_fixed' => '/Selector/Fixed.php',
            'etsy_ab2_selector_hashrandomizer' => '/Selector/HashRandomizer.php',
            'etsy_ab2_selector_random' => '/Selector/Random.php',
            'etsy_ab2_selector_randomizer' => '/Selector/Randomizer.php',
            'etsy_ab2_selector_sequence' => '/Selector/Sequence.php',
            'etsy_ab2_selector_weighted' => '/Selector/Weighted.php',
            'etsy_ab2_subjectidprovider' => '/SubjectIDProvider.php',
            'etsy_ab2_systemlogger' => '/SystemLogger.php',
            'etsy_ab2_test' => '/Test.php',
            'etsy_ab2_variant' => '/Variant.php',
            'etsy_ab2_variantutils' => '/VariantUtils.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);
