<template>
  <div>
    <div>Search By Product Code with Vue</div>
    <input 
      v-model="inputCode" 
      type="text" 
      name="" id="" 
      placeholder="Search by Product Code"
      v-on:input="searchByProductCode()"
      >
      <!-- <button v-on:click="searchByProductCode()">Search</button> -->

    <table v-if="result != '' && inputCode" class="table table-bordered table-striped">
      <thead>
        <tr>
            <th>Product Code</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="item in result" :key="item.id">
            <td>{{ item.product_code }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.price }}</td>
            <td>
              <a :href="'/backside/shop_owner/items/'+item.id"><span class="fa fa-info-circle"></span></a>
              <a :href="'/backside/shop_owner/items/'+item.id+'/edit'"><span class="fa fa-edit"></span></a>
            </td>
          </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["items"],
  data() {
    return {
      inputCode: '',
      result: '',
    }
  },
  methods: {
    searchByProductCode: function() {
      if(this.inputCode == '' && this.inputCode.length <= 2) {
        this.result == '';
      } else if(this.inputCode != '' && this.inputCode.length > 2) {
        let searchResult = [];
        this.items.forEach(item => {
          if(item.product_code.includes(this.inputCode)) {
            searchResult.push(item);
          }
        })
        this.result = searchResult;
      } else {
        this.result = '';
      }
    },
  }
}
</script>

<style>

</style>