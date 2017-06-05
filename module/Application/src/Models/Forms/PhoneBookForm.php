<?php
namespace Application\Models\Forms;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Hidden;

class PhoneBookForm extends Form
{   
  public function __construct(){
      parent::__construct('PhoneBookForm');
     
    $id = new Hidden('id');
    $this->add($id);
    
    $FirstName = new Text(
                'FirstName',            // Name of the element
                [                     // Array of options
                 'label'=> 'First name'  // Text label
                ]);
    $this->add($FirstName);
    $LastName = new Text(
                'LastName',            // Name of the element
                [                     // Array of options
                 'label'=> 'Last name'  // Text label
                ]);
    $this->add($LastName);
  
    $HomePhone = new Text(
                'HomePhone',            // Name of the element
                [                     // Array of options
                 'label'=> 'Home phone'  // Text label
                ]);
    $this->add($HomePhone);

    $MobilePhone = new Text(
                'MobilePhone',            // Name of the element
                [                     // Array of options
                 'label'=> 'Cell phone'  // Text label
                ]);
    $this->add($MobilePhone);

    $Email = new Text(
                'Email',            // Name of the element
                [                     // Array of options
                 'label'=> 'Email'  // Text label
                ]);
    $this->add($Email);
    
    $WorkTitle = new Text(
                'WorkTitle',            // Name of the element
                [                     // Array of options
                 'label'=> 'Work title'  // Text label
                ]);
    $this->add($WorkTitle);

    $this->addInputFilter();  
  }
  
  private function addInputFilter() 
  {
    $inputFilter = new \Zend\InputFilter\InputFilter();        
    $this->setInputFilter($inputFilter);
    
    $inputFilter->add([
        'name'     => 'id',
        'filters'  => [
           ['name' => 'Int'],                    
        ]       
    ]);
    
    $inputFilter->add([
        'name'     => 'MobilePhone',
        'required' => true,                
        'validators' => [
            [
                'name' => 'Callback',
                'options' => [
                    'callback' => [$this, 'validatePhone'],
                    'callbackOptions' => [
                        'format' => 'local'
                    ]
                ]                        
            ]                    
        ]
    ]);
    $inputFilter->add([
        'name'     => 'HomePhone',
        'required' => true,                
        'validators' => [
            [
                'name' => 'Callback',
                'options' => [
                    'callback' => [$this, 'validatePhone'],
                    'callbackOptions' => [
                        'format' => 'intl'
                    ]
                ]                        
            ]                    
        ]
    ]);
    $inputFilter->add([
        'name'     => 'Email',
        'required' => true,
        'filters'  => [
           ['name' => 'StringTrim'],                    
        ],                
        'validators' => [
           [
            'name' => 'EmailAddress',
            'options' => [
              'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
              'useMxCheck' => false,                            
            ],
          ],
        ],
      ]
    );
    $inputFilter->add([
        'name'     => 'WorkTitle',
        'required' => false,
        'filters'  => [
           ['name' => 'StringTrim'],
           ['name' => 'StripTags'],
           ['name' => 'StripNewlines'],
        ],                
        'validators' => [
           [
            'name' => 'StringLength',
              'options' => [
                'min' => 1,
                'max' => 45
              ],
           ],
        ],
      ]
    );
    $inputFilter->add([
        'name'     => 'LastName',
        'required' => true,
        'filters'  => [
           ['name' => 'StringTrim'],
           ['name' => 'StripTags'],
           ['name' => 'StripNewlines'],
        ],                
        'validators' => [
           [
            'name' => 'StringLength',
              'options' => [
                'min' => 1,
                'max' => 45
              ],
           ],
        ],
      ]
    );
    $inputFilter->add([
        'name'     => 'FirstName',
        'required' => true,
        'filters'  => [
           ['name' => 'StringTrim'],
           ['name' => 'StripTags'],
           ['name' => 'StripNewlines'],
        ],                
        'validators' => [
           [
            'name' => 'StringLength',
              'options' => [
                'min' => 1,
                'max' => 45
              ],
           ],
        ],
      ]
    );

  }
  
  public function validatePhone($value, $context, $format) 
  {
    // Determine the correct length and pattern of the phone number,
    // depending on the format.
    if($format == 'intl') {
      $correctLength = 12;
      $pattern = '/^\d{2}-\d{3}-\d{2}-\d{2}$/';
    } else { // 'local'
      $correctLength = 11;
      $pattern = '/^\d{3}-\d{3}-\d{3}$/';
    }
                
    // Check phone number length.
    if(strlen($value)!=$correctLength)
      return false;

    // Check if the value matches the pattern.
    $matchCount = preg_match($pattern, $value);
        
    return ($matchCount!=0)?true:false;
  } 
}