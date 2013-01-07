<h2>Employee details: <?php echo $data->first_name . ' ' . $data->last_name ?></h2>
<table class="table table-bordered">
    <tr>
        <th>emp_no</th><td><?php echo $data->emp_no; ?></td>
    </tr><tr>
        <th>birth_date</th><td><?php echo $data->birth_date; ?></td>
    </tr><tr>
        <th>first_name</th><td><?php echo $data->first_name; ?></td>
    </tr><tr>
        <th>last_name</th><td><?php echo $data->last_name; ?></td>
    </tr><tr>
        <th>gender</th><td><?php echo $data->gender; ?></td>
    </tr><tr>
        <th>hire_date</th><td><?php echo $data->hire_date; ?></td>
    </tr><tr>
        <th>role_name</th><td><?php echo $data->name; ?></td>
    </tr><tr>
        <th>titles</th>
    <td>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Title</th>
                <th>from_date</th>
                <th>to_date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($titles as $t): ?>
                <tr>
                    <td><?php echo $t->title ?></td>
                    <td><?php echo $t->from_date ?></td>
                    <td><?php echo $t->to_date ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </td>
    </tr><tr>
        <th>departments</th>
    <td>
        <?php if ($deDepartments): ?>
        <h5>Standart Employee</h5>
            <hr/>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>department</th>
            <th>to_date</th>
            <th>from_date</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($deDepartments as $d): ?>
        <tr>
            <td><?php echo $d->dept_name ?></td>
            <td><?php echo $d->from_date ?></td>
            <td><?php echo $d->to_date ?></td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        <?php endif; ?>

        <?php if ($dmDepartments): ?>
        <br/>
        <h5>Manager</h5>
        <hr/>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>department</th>
                <th>to_date</th>
                <th>from_date</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($dmDepartments as $d): ?>
            <tr>
                <td><?php echo $d->dept_name ?></td>
                <td><?php echo $d->from_date ?></td>
                <td><?php echo $d->to_date ?></td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
        </td>
    </tr>
    <?php if (in_array($user->role_name, array('hr', 'super'))): ?>
    <tr>
        <th>salaries</th>
        <td>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Salary</th>
                    <th>to_date</th>
                    <th>from_date</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($salaries as $s): ?>
                <tr>
                    <td><?php echo $s->salary ?></td>
                    <td><?php echo $s->from_date ?></td>
                    <td><?php echo $s->to_date ?></td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>
    <?php endif ?>
</table>