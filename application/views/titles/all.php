<?php

if ($canSee):

echo form_open(base_url('index.php/titles/all'), array('method' => 'get', 'class' => 'form-search'));
if ($canSeeComponent)
echo form_input(array(
    'name' => 'empno',
    'placeholder' => 'emp_no',
    'class' => 'search-query'
));
echo form_input(array(
    'name' => 'firstname',
    'placeholder' => 'firstname',
    'class' => 'search-query'
));
echo form_input(array(
    'name' => 'lastname',
    'placeholder' => 'lastname',
    'class' => 'search-query'
));
if ($canSeeComponent)
    echo form_input(array(
        'name' => 'title',
        'placeholder' => 'title',
        'class' => 'search-query'
));
echo form_button(array(
    'name' => 'button',
    'type' => 'submit',
    'content' => 'Search',
    'class' => 'btn btn-primary'
));
echo form_close();

?>


<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <?php if ($canSeeComponent): ?><th>emp_no</th><?php endif ?>
        <th>first_name</th>
        <th>last_name</th>
        <th>title</th>
        <?php if ($canSeeComponent): ?>
            <th>from_date</th>
            <th>to_date</th>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php if($results) { ?>
        <?php foreach ($results as $data) { ?>
        <tr>
            <?php if ($canSeeComponent): ?><td><?php echo $data->emp_no; ?></td><?php endif; ?>
            <td><?php echo $data->first_name; ?></td>
            <td><?php echo $data->last_name; ?></td>
            <td><?php echo $data->title; ?></td>
            <?php if ($canSeeComponent): ?>
                <td><?php echo $data->from_date;  ?></td>
                <td><?php echo $data->to_date; ?></td>
                <td class="icon"><?php if (date("Y-m-d") < $data->to_date): ?><a class="icon-edit" href="<?php echo base_url('index.php/titles/edit/'.$data->emp_no) ?>"></a><?php endif; ?></td>
            <?php endif; ?>
        </tr>
            <?php }
    }?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="<?php echo $canSeeComponent ? 5 : 2 ?>"></td>
        <td colspan="2">
            Page rendered in <strong>{elapsed_time}</strong> seconds
        </td>
    </tr>
    </tfoot>
</table>
<?php echo $links; ?>
<?php endif ?>
