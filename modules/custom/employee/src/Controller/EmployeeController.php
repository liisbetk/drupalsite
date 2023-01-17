<?php
    namespace Drupal\employee\Controller;

    use Drupal\Core\Controller\ControllerBase;
    use Drupal\Code\Database\Database;

    class EmployeeController extends Controllerbase{

        public function createEmployee(){
            $form = \Drupal::formBuilder()->getForm('Drupal\employee\Form\EmployeeForm');
            $renderFrom = \Drupal::service('renderer')->render($form);

            return [
                '#type' => 'markup',
                '#markup' => $renderFrom,
                '#title' => 'Employee form'

            ];
        }

        public function getEmployeeList(){
                $limit = 3;
                $query = \Drupal::database();
                $result = $query->select('employees', 'e')
                ->fields('e', ['id', 'name', 'gender', 'about'])
                ->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit($limit)
                ->execute()->fetchAll(\PDO::FETCH_OBJ);

                $data = [];
                $count = 1;

                $params = \Drupal::request()->query->all();

                if(empty($params) || $params['page'] == 0){
                    $count = 1;
                } else if($params['page'] == 1) {
                    $count = $params['page'] + $limit;
                } else {
                    $count = $params['page'] * $limit;
                    $count++;
                }



                foreach($result as $row){
                    $data[] = [
                        'serial_no' => $count.".",
                        'name' => $row->name,
                        'gender'=> $row->gender,
                        'about' => $row->about,
                        'edit' => $this->t("<a href='edit-employee/$row->id'>Edit</a>"),
                        'delete' => $this->t("<a href='delete-employee/$row->id'>Delete</a>"),
                    ];
                    $count++;
                }
                $header = array('Number','name', 'gender', 'about', 'Edit', 'Delete');

                $build['table'] = [
                    '#type' => 'table',
                    '#header' => $header,
                    '#rows' => $data,
                ];

                $build['pager'] = [
                    '#type' => 'pager'
                ];

                return [
                        $build,
                        '#title' => 'Employee list'
                ];
        }

        public function deleteEmployee($id){

            $query = \Drupal::database();
            $query->delete('employees')
            ->condition('id', $id, '=')
            ->execute();

            $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../employee-list');
            $response->send();

            $this->messenger()->addMessage('Employee deleted successfully!', 'status', TRUE);
        }
    }