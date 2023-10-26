  <!-- Zh Pop up for detail -->
  <div id="myModal" class="modal fade" role="dialog">

      <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Role Detail</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <table class="table">
                      <tbody>
                          <tr id="userNameRow">
                              <th scope="row">Username</th>
                              <td id="userName"></td>
                          </tr>
                          <tr id="userPhoneRow">>
                              <th scope="row">Phone</th>
                              <td id="userPhone"></td>
                          </tr>
                          <tr id="userRoleRow">>
                              <th scope="row">User Role</th>
                              <td id="userRole"></td>
                          </tr>
                          <tr>
                              <th scope="row">Action</th>
                              <td id="action"></td>
                          </tr>
                      </tbody>
                  </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>


      </div>

  </div>


  @push('scripts')
      <script>
          function checkDetail(id, action) {
              $.ajax({
                  method: "GET",
                  url: "{{ route('backside.shop_owner.getbackrole.detail') }}",
                  dataType: "json",
                  data: {
                      id: id,
                  },
                  success: function(data) {
                      console.log(data);
                      var old_role = data.old_role_id;
                      var new_role = data.new_role_id;
                      console.log(old_role);
                      console.log(new_role);
                      if (data.new_name != null && data.new_name != "no") {
                          document.getElementById("userName").textContent = "from " + data.old_name + " to " +
                              data.new_name;
                      } else if (data.new_name == null) {
                          document.getElementById("userNameRow").style.display = "none";
                      } else if (data.new_name == "no") {
                          document.getElementById("userNameRow").style.display = "none";
                      }
                      if (data.new_phone != null && data.new_phone != "no") {
                          document.getElementById("userPhone").textContent = "from " + data.old_phone + " to " +
                              data.new_phone;
                      } else if (data.new_phone == null) {
                          document.getElementById("userPhoneRow").style.display = "none";
                      } else if (data.new_phone == "no") {
                          document.getElementById("userPhoneRow").style.display = "none";
                      }
                      if (data.new_role_id != null && data.new_role_id != "no") {
                          document.getElementById("userRole").textContent = "from " + data.old_role_id + " to " +
                              data.new_role_id;
                      } else if (data.new_role_id == null) {
                          document.getElementById("userRoleRow").style.display = "none";
                      } else if (data.new_role_id == "no") {
                          document.getElementById("userRoleRow").style.display = "none";
                      }
                      document.getElementById("action").textContent = action;
                  },
                  error: function(error) {
                      console.log(`Error ${error}`);
                  }
              });
          }
      </script>
  @endpush
