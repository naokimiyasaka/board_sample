  <table class="table table-bordered table-striped">
    <thead>
      <tr style="background-color:#d9edf7;">
        <th>部署</th>
        <th>名前</th>
        <th>メールアドレス</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$data item=row}
      <tr>
        <td>{$row.user_post_id}</td>
        <td>{$row.name}</td>
        <td>{$row.email}</td>
        <td><a href="?mode=user&action=edit&id={$row.id}" class="btn"><i class="icon-pencil"></i> 編集</a></td>
        <td><a href="?mode=user&action=delete&id={$row.id}" class="btn btn-danger"><i class="icon-remove"></i> 削除</a></td>
      </tr>
      {/foreach}
    </tbody>
  </table>
