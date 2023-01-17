<?php

    namespace Drupal\employee\Form;

    use Drupal\Core\Form\Formbase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Core\Database\Database;

class EmployeeForm extends Formbase{

    /**
     *{@inheritDoc}
     */

     public function getFormId()
     {
        return 'create_employee';
     }

     /**
      * {@inheritDoc}
      */

      public function buildForm(array $form, FormStateInterface $form_state)
      {

        $genderOpt= array(
            '0' => 'select gender',
            'male' => 'Male',
            'female' => 'Female',
        );
        $form['name']= array(
            '#type' => 'textfield',
            '#title' => 'Name',
            '#default_value' => '',
            '#attributes' => array(
                'placeholder' => 'name'
            )
        );


        $form['gender'] = array(
            '#type' => 'select',
            '#title' => 'Gender',
            '#options' => $genderOpt,
        );

        $form['about'] = array(
            '#type' => 'textfield',
            '#title' => 'job description',
            '#dedault_value' => '',
            '#attributes' => array(
                'placeholder' => 'Your job description'
            )
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Save',
            '#button_type' => 'primary'
        );

        return $form;
      }

      /**
       *{@inheritDoc}
       */

       public function validateForm(array &$form, FormStateInterface $form_state)
       {

        //Mulle tundub, et mõistlikum on kasutada buildFormis #required => true rida. Pean uurima, miks
// näidetes pidevalt validateFormi kasutatakse.
        $name =  $form_state->getValue('name');

        if(trim($name) == '') {
            $form_state->setErrorByName('name',$this->t('Name is required'));
        }
        if($form_state->getValue('gender') == '0') {
            $form_state->setErrorByName('gender',$this->t('Select your gender'));
        }
        if($form_state->getValue('about') == '') {
            $form_state->setErrorByName('about',$this->t('Please enter your job description'));
        }
       }

      public function submitForm(array &$form, FormStateInterface $form_state)
      {
        $postData = $form_state->getValues();

        $query = Database::getConnection();
        $query->insert('employees')->fields(
            array(
                'name' => $form_state->getValue('name'),
                'gender' => $form_state->getValue('gender'),
                'about' => $form_state->getValue('about'),
            )
        )->execute();

        $this->messenger()->addMessage('Data saved successfully!', 'status', TRUE);

      }
}