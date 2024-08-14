<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="create__task">
                <h1>Публикация нового задания</h1>
                <div class="create__task-main">
                <?php $form = ActiveForm::begin(['id' => 'task-form',
                    'options' => ['class' => 'create__task-form form-create', 'enctype' => 'multipart/form-data', 'enableAjaxValidation' => true,
                'enableClientValidation' => true, ]]); ?>
                   <?= $form->field($model, 'name_task')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder' => 'Повесить полку'])
                    ->label('Мне нужно'); ?>    
                        <span>Кратко опишите суть работы</span>
                    <?= $form->field($model, 'description')->textarea(['rows' => 7, 'placeholder' => 'Place your text'])    
                    ->label('Подробности задания'); ?>
                        <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>
                        <?php 
                    $items = ArrayHelper::map($categories,'id','name');
                    $params = ['prompt' => 'Выберите категорию'];
                    echo $form->field($model, 'category_id')->dropDownList($items,$params);
                ?>    
                        <label>Файлы</label>
                        <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
                        <div class="create__file">
                            <!-- <span>Добавить новый файл</span> -->
                           <!--                          <input type="file" name="files[]" class="dropzone">-->
                           <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'class' => 'dropzone', 'accept' => 'image/*'])
                        ->label(false); ?>
                        </div>
                        
                        <!-- <label for="13">Локация</label> -->
                        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                        <!-- <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район"> -->
                        <span>Укажите адрес исполнения, если задание требует присутствия</span>
                        <div class="create__price-time">
                            <div class="create__price-time--wrapper">
                                <!-- <label for="14">Бюджет</label> -->
                                <?= $form->field($model, 'budget')->textInput(['class' => 'form-control input-middle input-money', 'placeholder' => '1000']) ?>
                                <!-- <textarea class="input textarea input-money" rows="1" id="14" name="" placeholder="1000"></textarea> -->
                                <span>Не заполняйте для оценки исполнителем</span>
                            </div>
                            <div class="create__price-time--wrapper">
                                <?= $form->field($model, 'date_of_completion')->textInput(['class' => 'form-control input-middle input-date','type' => 'date', 'placeholder' => '10.11, 15:00'])
                                 ->label('Срок исполнения'); ?>
                                <span>Укажите крайний срок исполнения</span>
                            </div>
                        </div>
                        <?= Html::submitButton('Опубликовать', ['class' => 'button', 'onclick' => 'getErrors()']) ?>
                        
                <?php ActiveForm::end(); ?>
                    <!-- </form> -->
                    <div class="create__warnings">
                        <div class="warning-item warning-item--advice">
                            <h2>Правила хорошего описания</h2>
                            <h3>Подробности</h3>
                            <p>Друзья, не используйте случайный<br>
                                контент – ни наш, ни чей-либо еще. Заполняйте свои
                                макеты, вайрфреймы, мокапы и прототипы реальным
                                содержимым.</p>
                            <h3>Файлы</h3>
                            <p>Если загружаете фотографии объекта, то убедитесь,
                                что всё в фокусе, а фото показывает объект со всех
                                ракурсов.</p>
                        </div>
                        <?php if (!$model->validate()):?>
                        <div class="warning-item warning-item--error">
                            <h2>Ошибки заполнения формы</h2>
                            <div id="item-error">
                                <?php 
                                if (!$model->validate()) {
                                echo Html::errorSummary($model, ['class' => 'errors']);
                                }
                                ?>
                            </div>
                           
                            <!-- <h3>Категория</h3>
                            <p>Это поле должно быть выбрано.<br>
                                Задание должно принадлежать одной из категорий</p> -->
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                
            </section>
        </div>
       
    </main>
    