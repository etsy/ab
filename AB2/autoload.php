<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'ab2_logger' => '/Logger.php',
            'ab2_logger_multilogger' => '/Logger/MultiLogger.php',
            'ab2_logger_testvarmap' => '/Logger/TestVarMap.php',
            'ab2_logger_uniqueentries' => '/Logger/UniqueEntries.php',
            'ab2_selector' => '/Selector.php',
            'ab2_selector_fixed' => '/Selector/Fixed.php',
            'ab2_selector_hashrandomizer' => '/Selector/HashRandomizer.php',
            'ab2_selector_random' => '/Selector/Random.php',
            'ab2_selector_randomizer' => '/Selector/Randomizer.php',
            'ab2_selector_sequence' => '/Selector/Sequence.php',
            'ab2_selector_weighted' => '/Selector/Weighted.php',
            'ab2_subjectidprovider' => '/SubjectIDProvider.php',
            'ab2_systemlogger' => '/SystemLogger.php',
            'ab2_test' => '/Test.php',
            'ab2_variant' => '/Variant.php',
            'ab2_variantutils' => '/VariantUtils.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);
