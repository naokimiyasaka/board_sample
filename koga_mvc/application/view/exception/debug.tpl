  <div class="well">
    <h1>Internal server error...</h1>
    <p>{$message}</p>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>file</th>
        <th>line</th>
        <th>function</th>
        <th>args</th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$trace item=row}
      <tr>
        <td>{$row.file}</td>
        <td>{$row.line}</td>
        <td>{$row.function}</td>
        <td>
          {if $row.args}
            {foreach from=$row.args item=arg}
              {$arg},
            {/foreach}
          {else}
            none
          {/if}
        </td>
      </tr>
      {/foreach}
    </tbody>
  </table>
