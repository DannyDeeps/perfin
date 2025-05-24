<script>
  /** @type {import("./$types").PageData} */
  export let data;
</script>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table class="table table-sm caption-top">
        <caption class="h2">Totals by Description</caption>
        <thead>
          <tr class="table-dark">
            <th>id</th>
            <th>source</th>
            <th>no. transactions</th>
            <th>in</th>
            <th>out</th>
          </tr>
        </thead>

        <tbody>
          {#each data.sources as source}
            <tr>
              <td
                >{#if source.count < 2}{source.id}{/if}</td
              >
              <td>{source.name}</td>
              <td>{source.count}</td>
              <td>&pound;{source.credit_amount}</td>
              <td>&pound;{source.debit_amount}</td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </div>
</div>
