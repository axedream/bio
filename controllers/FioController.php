<?php

namespace app\controllers;

use app\models\Pacient;
use app\models\Bio;
use app\models\user\User;
use app\models\UserExcel;
use Yii;
use yii\filters\AccessControl;
use app\models\UserFio;
use moonland\phpexcel\Excel;


class FioController extends BasicController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Отдельные классы экшинов
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Отобразить полный список
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = UserFio::find()->all();
        return $this->render('index',['model'=>$model]);
    }

    /**
     * Форма добавления
     *
     * @return string
     */
    public function actionAdd(){
        $model = new UserFio();

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                //$this->put_excel_data($model->excel_data,$model->id);
                return $this->actionIndex();
            }
        }


        return $this->render('form',['model'=>$model]);
    }


    /**
     * Редактировать/просматривать
     *
     * @param bool $id
     * @return string
     */
    public function actionEdit($id=FALSE)
    {
        $model_excel = 0;

        if ($id && UserFio::find()->where(['id'=>$id])->exists()) {
            $model = UserFio::findOne($id);
            if (Pacient::find()->where(['user_fio_id'=>$id])->exists()) {
                $model_paticent = Pacient::find()->where(['user_fio_id'=>$id])->all();
            } else {
                $model_paticent = FALSE;
            }

            if (Yii::$app->request->post()) {
                $model->load(Yii::$app->request->post());
                if ($model->validate()) {
                    $model->update();
                    $this->put_excel_data($model->excel_data,$model->id);
                    return $this->actionIndex();
                }
            }

            return $this->render('form',['model'=>$model,'model_patient'=>$model_paticent]);
        }
        return $this->actionIndex();
    }


    /**
     * Удалить
     *
     * @param bool $id
     * @return string
     */
    public function actionDelete($id=FALSE) {

        if ($id && UserFio::find()->where(['id'=>$id])->exists()) {
            $model = UserFio::findOne(['id'=>$id]);
            $model->delete();

            //если есть записи по ID UserFio в UserExcel, удалим их
            if (Pacient::find()->where(['user_fio_id'=>$id])->exists()) {
                $connection = Yii::$app->db;
                $connection->createCommand()->delete('pacient', 'user_fio_id = "' . $id . '"')->execute();
            }

        }
        return $this->actionIndex();
    }


    /**
     * Отображаем данные в таблице UserExcel
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionShow($id) {
        if (UserFio::find()->where(['id'=>$id])->exists() && Pacient::find()->where(['user_fio_id'=>$id])->exists()) {
            $model = Pacient::find()->where(['user_fio_id'=>$id])->all();
            $model_user_name = UserFio::findOne($id);
            $user_name = $model_user_name->user_name;
            return $this->render('show',['model'=>$model,'user_name'=>$user_name]);
        }
        return $this->actionIndex();
    }

    /**
     * Обрабатываем данные полученные из файла EXCEL/CSV
     *
     * @param $excel_data
     * @param int $id
     */
    public function put_excel_data($excel_data,$id=0){

        //file_put_contents("c:\\OSPanel\\domains\\genomed\\micro.genomed.local\\my.txt","\nВыводимые данные:\n\n".print_r($excel_data,TRUE), FILE_APPEND | LOCK_EX );

        $flag_mess = 1;
        if (!empty($excel_data) && $id) {

            //если есть записи по ID UserFio в Pacient, удалим их
            if (Pacient::find()->where(['user_fio_id'=>$id])->exists()) {
                //очищаем таблицу пациента, если есть записи
                $connection = Yii::$app->db;
                $connection->createCommand()->delete('pacient', 'user_fio_id = "' . $id . '"')->execute();
            }
            $error = 0;

            foreach ($excel_data as $data) {

                $model_pacient = new Pacient();

                $taxon = (int)trim($data['taxon']);

                $model_pacient->user_fio_id = $id;
                $model_pacient->count = (int)trim($data['count']);
                $model_pacient->count_norm = (int)trim($data['count_norm']);


                if ($taxon && is_numeric($taxon) && Bio::find()->where(['taxon'=>$taxon])->exists()) {
                    $model_bio = Bio::findOne(['taxon'=>$taxon]);
                } else {
                    $model_bio = new Bio();

                    $model_bio->taxon = $taxon;
                    $model_bio->tax_name = (string)$data['tax_name'];
                    $model_bio->tax_rank = (string)$data['tax_rank'];
                    $model_bio->parent = (int)$data['parent'];
                    if (!$model_bio->save()) {
                        $error = 1;
                        $text_error = 'Ошибка загрузки справочника Bio!';
                        foreach ($model_bio->getErrors() as $key => $value) { $text_error = 'Ошибка: ' . $key . ': ' . $value[0] ."\n"; }
                        Yii::$app->getSession()->setFlash('success',$text_error);
                        return FALSE;
                    }
                }

                $model_pacient->bio_id = $model_bio->id;

                if ($model_pacient->save()) {
                    $error = 0;
                } else {
                    $error = 1;
                }

                unset($model_pacient,$model_bio);
            }

            if (!$error) {
                if ($flag_mess) {
                    Yii::$app->getSession()->setFlash('success','Загрузка данных EXCEL/CSV успешно выполнена');
                    $flag_mess = 0;
                }
            } else {
                if ($flag_mess) {
                    Yii::$app->getSession()->setFlash('danger','Загрузка данных EXCEL/CSV выполнена, но с ошибками (Не все строки загружены)');
                    $flag_mess = 0;
                }

            }
        }
        if ($flag_mess) {
            Yii::$app->getSession()->setFlash('info','Загрузка данных EXCEL/SCV не выполнялась');
            $flag_mess = 0;
        }
    }

    public function actionInfo_bio($id=FALSE) {
        $this->init_ajax();

        if ($id && is_numeric($id) && Bio::find()->with(['id'=>$id])->exists()) {
            $model_bio = Bio::findOne($id);
            $this->error = 'no';
            $this->msg =  Yii::$app->view->renderFile('@app/views/bio/modal_form_bio.php',['model'=>$model_bio]);
        }

        return $this->out();
    }

}
