<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #CCC;
    padding: 3px 7px 2px 7px;
}

#customers th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #5eb0f0;
    color: #ffffff;
}

#customers tr.alt td {
    color: #000000;
    background-color: #e0005f;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 imgchanel">
    <div class="wrapper-box">
        <div class="wrapper-content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">

                </div>
            </div>
            <?php if (isset($models) && !empty($models) && count($models) > 0) { ?>

                <table id="customers" class="table table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Main Image</th>
                            <th style="width: 20%;">Collage Background Image</th>
                            <th style="width: 10%;">Updated At</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($models); $i++) { ?>
                            <tr>
                                <td><img alter="collage" style="width:140px;height:80px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/<?php echo $models[$i]->main_img; ?>"></td>
                                <td><img alter="collage" style="width:140px;height:80px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/<?php echo $models[$i]->cropped_img; ?>"></td>
                                <td><?php echo $models[$i]->updated_at; ?></td>
                                <td class="text-right">
                                        <a class="delete_img" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">Delete</a>
                                        <a class="edit_img" img_name="<?php echo $models[$i]->main_img; ?>" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">| Edit</a>
                                </td>
                            </tr>
    <?php } ?>
                    </tbody>

                </table>

                <?php } ?>
            <div style="margin-top:20px;">

                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                ))
                ?>

            </div>
        </div>
    </div>
</div>