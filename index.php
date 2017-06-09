<?php
//include_once('validator/EmptyValidator.php');

include_once('Inputs/Text.php');

$text = new Text('name', array(		'class' => "name red",
									'id' => 'name', 
									'data-test' => 'testing'
								)
				);
$text->addValidator(array('Empty'=>'This is requireds.'));

$text1 = new Text('name1', array(		'class' => "name red",
										'id' => 'name1', 
										'data-test' => 'testing'
								)
				);

$text1->addValidator(array('Empty'=>'This is required1.'));



if(isset($_POST) && !empty($_POST))
{
	//print_r($_POST);

	if(!$text->valid())
	{
		//print_r($text->validationError());echo "<br>";		
	}

	if(!$text1->valid())
	{
		//print_r($text1->validationError());echo "<br>";
	}

	print_r($text->validationErrors());


}

?>

<form method='POST'>
	<?php
		echo $text->render();
		echo $text1->render();
	?>
	<input type="submit" name="submit">
</form>

