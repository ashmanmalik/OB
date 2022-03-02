<script type="text/javascript">
	var url = "https://au-api.basiq.io/users/0234ee93-4f7e-4641-b830-a867e42b1101";

var xhr = new XMLHttpRequest();
xhr.open("DELETE", url);

xhr.setRequestHeader("Authorization", "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyaWQiOiI0MzhjYWUxNS03YzE4LTRiYmYtYjg1ZS01NTZiNDlkZDUyNTkiLCJhcHBsaWNhdGlvbmlkIjoiNzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczIiwic2NvcGUiOiJTRVJWRVJfQUNDRVNTIiwic2FuZGJveF9hY2NvdW50IjpmYWxzZSwiY29ubmVjdF9zdGF0ZW1lbnRzIjp0cnVlLCJlbnJpY2giOiJwYWlkIiwiZW5yaWNoX2FwaV9rZXkiOiJuRlpYZXJHcEY3N2Vvd010ZG92Z2phWE9iZmdvdDM0OTE3Unc4aGlaIiwiZW5yaWNoX2VudGl0eSI6dHJ1ZSwiZW5yaWNoX2xvY2F0aW9uIjp0cnVlLCJlbnJpY2hfY2F0ZWdvcnkiOnRydWUsImFmZm9yZGFiaWxpdHkiOiJwYWlkIiwiaW5jb21lIjoicGFpZCIsImV4cGVuc2VzIjoicGFpZCIsImV4cCI6MTY0NjIwMTk5OCwiaWF0IjoxNjQ2MTk4Mzk4LCJ2ZXJzaW9uIjoiMy4wIiwiZGVuaWVkX3Blcm1pc3Npb25zIjpbXX0.mAjdNImUWw19IU0sexyeo0WvUj4xZuM9l6YZ8t75eN8");

xhr.onreadystatechange = function () {
   if (xhr.readyState === 4) {
      console.log(xhr.status);
      console.log(xhr.responseText);
   }};

xhr.send();

</script>