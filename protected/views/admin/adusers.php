<div id="pageTitle">
    <h2 class="thick-title page-title-bar">User List</h2>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="wrapper-box">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">

                    </div>
                </div>
                <?php if (isset($models) && !empty($models) && count($models) > 0) { ?>
                    <div class="app-scrollable">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">User Name</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 15%;">Mobile</th>
                                    <th style="width: 15%;">Country Name</th>
                                    <th style="width: 15%;">Created At</th>
                                    <th style="width: 15%;">Ip Address</th>
                                    <th style="width: 15%;">Role</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($models); $i++) { ?>
                                    <tr>
                                        <td><?php echo $models[$i]->tu_username; ?></td>
                                        <td><?php echo $models[$i]->tu_email; ?></td>
                                        <td><?php echo $models[$i]->tu_mobile; ?></td>
                                        <td><?php echo $models[$i]->tu_long_country; ?></td>
                                        <td><?php echo $models[$i]->tu_created_at; ?></td>
                                        <td><?php echo $models[$i]->tu_ip; ?></td>
                                        <td><?php if ($models[$i]->tu_role == 3) echo "Admin";
                            else echo "User"; ?></td>
                                        <td><?php if ($models[$i]->tu_status == 0) echo "Inactive";
                            else echo "Active"; ?></td>
                                        <td class="text-right">
                                            <a style="display:none;" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['adeditgame']) . '/' . $models[$i]->tu_user_key; ?>">Edit</a>
                                    <?php if ($models[$i]->tu_role != 3) { ?><a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['addeleteuser']) . '/' . $models[$i]->tu_user_key; ?>">Delete</a><?php } ?>
                                        </td>
                                    </tr>
    <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
</div>