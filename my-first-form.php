<?php

echo "<p>POST:</p>";
var_dump($_POST);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My First HTML Form</title>
			<script>
		      var items = {};
		      items.list = {};
		      items.list.table = null;

		      
		      items.list.open = function() {
		        var tableSize = 5 * 1024 * 1024; // 5MB
		        items.list.table = openDatabase("Todo", "1.0", "Todo manager", tableSize);
		      }
		      
		      items.list.createTable = function() {
		        var table = items.list.table;
		        table.transaction(function(tx) {
		          tx.executeSql("CREATE TABLE IF NOT EXISTS todo(ID INTEGER PRIMARY KEY ASC, todo TEXT, added_on DATETIME)", []);
		        });
		      }
		      
		      items.list.addTodo = function(todoText) {
		        var table = items.list.table;
		        table.transaction(function(tx){
		          var addedOn = new Date();
		          tx.executeSql("INSERT INTO todo(todo, added_on) VALUES (?,?)",
		              [todoText, addedOn],
		              items.list.onSuccess,
		              items.list.onError);
		         });
		      }
		      
		      items.list.onError = function(tx, e) {
		        alert("There has been an error: " + e.message);
		      }
		      
		      items.list.onSuccess = function(tx, r) {
		        // re-render the data.
		        items.list.getAllTodoItems(loadTodoItems);
		      }
		      
		      
		      items.list.getAllTodoItems = function(renderFunc) {
		        var table = items.list.table;
		        table.transaction(function(tx) {
		          tx.executeSql("SELECT * FROM todo", [], renderFunc,
		              items.list.onError);
		        });
		      }
		      
		      items.list.deleteTodo = function(id) {
		        var table = items.list.table;
		        table.transaction(function(tx){
		          tx.executeSql("DELETE FROM todo WHERE ID=?", [id],
		              items.list.onSuccess,
		              items.list.onError);
		          });
		      }
		      
		      function loadTodoItems(tx, rs) {
		        var rowOutput = "";
		        var todoItems = document.getElementById("todoItems");
		        for (var i=0; i < rs.rows.length; i++) {
		          rowOutput += renderTodo(rs.rows.item(i));
		        }
		      
		        todoItems.innerHTML = rowOutput;
		      }
		      
		      function renderTodo(row) {
		        return "<li>" + row.todo  + " [<a href='javascript:void(0);'  onclick='items.list.deleteTodo(" + row.ID +");'>Delete</a>]</li>";
		      }
		      
		      function init() {
		        items.list.open();
		        items.list.createTable();
		        items.list.getAllTodoItems(loadTodoItems);
		      }
		      
		      function addTodo() {
		        var todo = document.getElementById("todo");
		        items.list.addTodo(todo.value);
		        todo.value = "";
		      }
		</script>
	</head>
	<body onload="init();">
		<h2>User Login</h2>
		<form method="POST" action="">
				    <p>
				       <label for="username">Username</label>
				        	<input id="username" name="username" type="text" placeholder="Enter your username">
				    	</p>
				   	<p>
				      <label for="password">Password</label>
				        	<input id="password" name="password" type="password" placeholder="Enter your password">
				    	</p>
			 <button type="submit">Log In</button>
		<h2>Compose an Email</h2>
				    <p>
				    	<label for="mailing_reciever">To:</label>
				    		<input type="text" id="mailing_reciever" name="mailing_reciever">
				    	</p>
				    		<p>
				    			<label for="mailing_sender">From:</label>
				    				<input type="text" id="mailing_sender" name="mailing_sender">
				    			</p>
				    				<p>
				    					<label for="mailing_subject">Subject</label>
				    						<input type="text" id="mailing_subject" name"mailing_subject">
				    					</p>
				    				<p>
				    			<textarea id="mailing_comment" name="mailing_comment" rows="5" cols="40" placeholder="Comment Here"></textarea>
				    		</p>
				    	<p>
				      <label for="mailing_checkbox">
				  			<input type="checkbox" id="mailing_checkbox" name="mailing_checkbox" value="yes" checked> Sign me up for the mailing list!
				  		</label>
				   </p>
		<h2>Multiple Choice Test</h2>
				    <p>What operating systems have you used?</p>
				    <p>
				      <label for="os1"><input type = "checkbox" id="os1" name="os[1]" value="linux"> Linux</label>
				  			<label for="os2"><input type="checkbox" id="os2" name="os[2]" value="windows"> Windows</label>
				  				<label for ="os3"><input type="checkbox" id="os3" name="os[3]" value="OSX"> OS X</label>
				    		</p>
				    	<p>What is the capital of Texas?</p>
				   <p>
				    <label for="q1a">
				    		<input type ="radio" id="q1a" name="q1" value="houston"> 
				    			Houston
				    				</label>
				    			<label for="q1b">
						    		<input type="radio" id="q1b" name="q1" value="dallas">
						    	Dallas
									</label>
								<label for="q1c">
						    		<input type="radio" id="q1c" name="q1" value="austin">
						    	Austin
									</label>
								<label for="q1d">
						    		<input type="radio" id="q1d" name="q1" value="san antonio">
						    San Antonio
						</label>
					</p>
					<p>What is your favorite car?</p>
						<p>
							<label for="q2a">
								<input type="radio" id="q2a" name="q2" value="lamborghini">
							Lamborghini
						</label>
							<label for="q2b">
								<input type="radio" id="q2b" name="q2" value="Dolorean">
							Dolorean
						</label>
							<label for="q2c">
								<input type="radio" id="q2c" name="q2" value="Ford">
							Ford Fusion 
						</label>
							<label for="q2d">
								<input type="radio" id="q2d" name="q2" value="BMW">
							BMW Z3
						</label>
					</p>
			<h2>Select Testing</h2>
					<p>
						<label for="transmission">Would you like it automatic? </label>
						<select id="transmission" name="transmission">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</p>
						<p>
							<label for="tv">What is your favorite tv show? </label>
							<select id="tv" name="tv[]" multiple>
								<option value="Naruto">Naruto</option>
							   	<option value="Yu-Gi-Oh">Yu-Gi-Oh</option>
								<option value="tableZ" selected>tableZ</option>
						</select>
					</p>
				<p>
			</p>	
				<button type="reset" value="Reset">Reset</button>
				</form>
			<h2>TODO List</h2>
				<form type="post" onsubmit="addTodo(); return false;" action="">
					<input type="text" id="todo" name="todo" placeholder="Add TODO Items" style="width: 200px;" />
				<input type="submit" value="Add"/>
			</form>
				<ul id="todoItems">
				</ul>
			<center>
			<br>
		</br>
			<a href="#top">Go to the top of the page</a>
		</center>
	</body> 
</html>