<?php

    namespace Drupal\employee\Form;

    use Drupal\Core\Form\Formbase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Core\Database\Database;

class EditEmployee extends Formbase{

     public function getFormId()
     {
        return 'edit_employee';
     }

      public function buildForm(array $form, FormStateInterface $form_state)
      {


        $id = \Drupal::routeMatch()->getParameter('id');
        $query = \Drupal::database();
        $data = $query->select('employees','e')
        ->fields('e', ['id', 'name', 'gender', 'about'])
        ->condition('e.id', $id, '=')
        ->execute()->fetchAll(\PDO::FETCH_OBJ);

        //print_r($data);


        $genderOpt= array(
            '0' => 'select gender',
            'male' => 'Male',
            'female' => 'Female',
        );
        $form['name']= array(
            '#type' => 'textfield',
            '#title' => 'Name',
            '#default_value' => $data[0]->name,
            '#attributes' => array(
                'placeholder' => 'name'
            )
        );


        $form['gender'] = array(
            '#type' => 'select',
            '#title' => 'Gender',
            '#options' => $genderOpt,
            '#default_value' => $data[0]->gender,
        );

        $form['about'] = array(
            '#type' => 'textfield',
            '#title' => 'job description',
            '#default_value' => $data[0]->about,
            '#attributes' => array(
                'placeholder' => 'Your job description'
            )
        );

        $form['update'] = array(
            '#type' => 'submit',
            '#value' => 'Update',
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
        $id = \Drupal::routeMatch()->getParameter('id');
        $postData = $form_state->getValues();

        $query = Database::getConnection();
        $query->update('employees')->fields(
            array(
                'name' => $form_state->getValue('name'),
                'gender' => $form_state->getValue('gender'),
                'about' => $form_state->getValue('about'),
            )
        )->condition('id', $id)
        ->execute();

        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../employee-list');
        $response->send();

        $this->messenger()->addMessage('Data updated successfully!', 'status', TRUE);

      }
}