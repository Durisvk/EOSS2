<?php
$coverage = new SebastianBergmann\CodeCoverage\CodeCoverage;
$coverage->setData(array (
  '/home/lchost/EOSS2/libs/Utils/File.php' => 
  array (
    21 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    22 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    23 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    24 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    25 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    28 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    29 => 
    array (
      0 => 'Tests\\Utils\\FileTest::testLineNumber',
    ),
    31 => 
    array (
    ),
    33 => NULL,
  ),
  '/home/lchost/EOSS2/libs/Utils/JSON.php' => 
  array (
    20 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testValidJSON',
      1 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      2 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    21 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testValidJSON',
      1 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
    ),
    23 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    24 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    25 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    28 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    29 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    30 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    31 => 
    array (
      0 => 'Tests\\Utils\\JSONTest::testFormattableJSON',
      1 => 'Tests\\Utils\\JSONTest::testInvalidJSON',
    ),
    33 => 
    array (
    ),
    35 => NULL,
  ),
));
$coverage->setTests(array (
  'Tests\\Utils\\FileTest::testLineNumber' => 
  array (
    'size' => 'unknown',
    'status' => 0,
  ),
  'Tests\\Utils\\JSONTest::testValidJSON' => 
  array (
    'size' => 'unknown',
    'status' => 0,
  ),
  'Tests\\Utils\\JSONTest::testFormattableJSON' => 
  array (
    'size' => 'unknown',
    'status' => 0,
  ),
  'Tests\\Utils\\JSONTest::testInvalidJSON' => 
  array (
    'size' => 'unknown',
    'status' => 0,
  ),
));

$filter = $coverage->filter();
$filter->setWhitelistedFiles(array (
  '/home/lchost/EOSS2/libs/Application/ApplicationLoader.php' => true,
  '/home/lchost/EOSS2/libs/Application/Config.php' => true,
  '/home/lchost/EOSS2/libs/Binding/BindableCollection.php' => true,
  '/home/lchost/EOSS2/libs/Binding/BindableProperty.php' => true,
  '/home/lchost/EOSS2/libs/Binding/BindedAttribute.php' => true,
  '/home/lchost/EOSS2/libs/Binding/CollectionBinding.php' => true,
  '/home/lchost/EOSS2/libs/Binding/ElementBinding.php' => true,
  '/home/lchost/EOSS2/libs/Binding/IBindableCollection.php' => true,
  '/home/lchost/EOSS2/libs/Binding/IBindableProperty.php' => true,
  '/home/lchost/EOSS2/libs/Binding/IBindedAttribute.php' => true,
  '/home/lchost/EOSS2/libs/Binding/PropertyBinding.php' => true,
  '/home/lchost/EOSS2/libs/Database/PDOWrapper.php' => true,
  '/home/lchost/EOSS2/libs/Debug/Linda.php' => true,
  '/home/lchost/EOSS2/libs/Debug/LindaLayout.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/AnonymousSender.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/CSI.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/CSIAnalyze.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/EOSS.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/Parameters.php' => true,
  '/home/lchost/EOSS2/libs/EOSS/Registry.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/BaseElement.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/Checkbox.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/FileInput.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/HiddenInput.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/IElement.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/OptionsBasedElement.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/RadioList.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/SelectBox.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/Submit.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/TextArea.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Controls/TextInput.php' => true,
  '/home/lchost/EOSS2/libs/Forms/Form.php' => true,
  '/home/lchost/EOSS2/libs/Forms/SubmittedForm.php' => true,
  '/home/lchost/EOSS2/libs/Http/FileUpload.php' => true,
  '/home/lchost/EOSS2/libs/Http/Request.php' => true,
  '/home/lchost/EOSS2/libs/Http/Response.php' => true,
  '/home/lchost/EOSS2/libs/Templating/BladeWrapper.php' => true,
  '/home/lchost/EOSS2/libs/Templating/ITemplateWrapper.php' => true,
  '/home/lchost/EOSS2/libs/Templating/LatteWrapper.php' => true,
  '/home/lchost/EOSS2/libs/Templating/TemplateFactory.php' => true,
  '/home/lchost/EOSS2/libs/Templating/TwigWrapper.php' => true,
  '/home/lchost/EOSS2/libs/Utils/CSIHelper.php' => true,
  '/home/lchost/EOSS2/libs/Utils/Client.php' => true,
  '/home/lchost/EOSS2/libs/Utils/EOSSHelper.php' => true,
  '/home/lchost/EOSS2/libs/Utils/File.php' => true,
  '/home/lchost/EOSS2/libs/Utils/HTML.php' => true,
  '/home/lchost/EOSS2/libs/Utils/JSON.php' => true,
  '/home/lchost/EOSS2/libs/Utils/JavascriptGenerator.php' => true,
  '/home/lchost/EOSS2/libs/Utils/RequireHelper.php' => true,
  '/home/lchost/EOSS2/libs/Utils/Session.php' => true,
  '/home/lchost/EOSS2/libs/Utils/Strings.php' => true,
  '/home/lchost/EOSS2/libs/vendor/autoload.php' => true,
));

return $coverage;