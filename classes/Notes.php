<?php
/**
 * 
 * Note : Les classes et les objets (PHP5)
 * @source http://www.manuelphp.com/php/language.oop5.php
 * @author michael
 *
 */

class Note{
	function __construct(){
		echo "note iciiii";
	}
}

// ---------------------------------------------------------------------------

class a {
	const CONST_VAR1 = "var1";
	const CONST_VAR2 = "var2";
	public $aaa;
	
	/**
	 * __toString() : PHP5 définit une nouvelle méthode __toString qui est appelée lors de l'affichage d'un objet (via echo ou print uniquement).
	 * $obj_a = new a();
	 * echo $obj_a;
	 */
	function __toString(){
		return "Class ".__CLASS__; // __METHOD__
	}
	
	function __construct($aaa){
		$this->aaa = $aaa;
	}
}
class b{
	private $bbb;
	function __construct($bbb) {
		$this->bbb = new a('bla bla');
	}
	function getAaa(){
		return $this->bbb;
	}
}

// $m = new b();
// echo $m->getAaa()->aaa;

// ---------------------------------------------------------------------------

// SOURCE : http://www.manuelphp.com/php/language.oop5.abstract.php
/*
abstract class AbstractClass 
{
    // Force la classe étendue à définir cette méthode
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // méthode commune
    public function printOut() {
        print $this->getValue() . "\n";
   }
}

class ConcreteClass1 extends AbstractClass 
{
     protected function getValue() {
       return "ConcreteClass1";
     }

     public function prefixValue($prefix) {
       return "{$prefix}ConcreteClass1";
    }
}

class ConcreteClass2 extends AbstractClass 
{
     public function getValue() {
       return "ConcreteClass2";
     }

     public function prefixValue($prefix) {
       return "{$prefix}ConcreteClass2";
    }
}

$class1 = new ConcreteClass1;
$class1->printOut();
echo $class1->prefixValue('FOO_') ."\n";

$class2 = new ConcreteClass2;
$class2->printOut();
echo $class2->prefixValue('FOO_') ."\n";
*/

// ---------------------------------------------------------------------------

// SOURCE : http://www.manuelphp.com/php/language.oop5.interfaces.php
/*
// Declaration de l'interface 'iTemplate'
interface iTemplate
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

// Implémentation de l'interface
// Ceci va fonctionner
class Template implements iTemplate
{
    private $vars = array();

    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }

    public function getHtml($template)
    {
        foreach($this->vars as $name => $value) {
            $template = str_replace('{' . $name . '}', $value, $template);
        }

        return $template;
    }
}

// Ceci ne fonctionnera pas
// Fatal error: Class BadTemplate contains 1 abstract methods
// and must therefore be declared abstract (iTemplate::getHtml)
class BadTemplate implements iTemplate
{
    private $vars = array();

    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }
}
*/

// ---------------------------------------------------------------------------

// SOURCE : http://www.manuelphp.com/php/language.oop5.iterations.php
class MyClass 
{
  public $var1 = 'valeur 1';
  public $var2 = 'valeur 2';
  public $var3 = 'valeur 3';

  protected $protected = 'variable protégée';
  private   $private   = 'variable privée';

  function iterateVisible() {
     echo "MyClass::iterateVisible:<br />";
     foreach($this as $key => $value) {
         print "$key => $value<br />";
     }
     echo "<hr />";
  }
}

$class = new MyClass();

foreach($class as $key => $value) {
    print "aaa: $key => $value<br />";
}
echo "<br />";

$class->iterateVisible();


// ---------------------------------------------------------------------------

?>