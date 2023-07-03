   <?php
    if (empty($_SESSION['name']) && empty($_SESSION['email'])) {
        header('location:login.php');
    }
    ?>
   <!---------------------------------Sell us Start-------------------------->
   <section id="sign-up">
       <div class="form-box-signup">
           <h3>Enter The Product Details</h3>
           <form action="#" class="form" method="post">
               <div class="form-grp">
                   <label for="shoesmodel" class="form-label">Model:</label>
                   <input type="text" name="name" class="form-input" id="name">
               </div>
               <div class="form-grp">
                   <label for="images" class="form-label">Images</label>
                   <input type="file" name="images" id="images" multiple>
               </div>
               <div class="form-grp">
                   <label for="usedfor" class="form-label">Used For:</label>
                   <input type="text" name="usedfor" class="form-input" id="usedfor">
               </div>
               <div class="form-grp">
                   <label for="condition" class="form-label">Condition:</label>
                   <select name="condition">
                       <option value="#" selected disabled>Choose</option>
                       <option value="Excellent">Excellent</option>
                       <option value="Good">Good</option>
                       <option value="Ecofriendly">Ecofriendly</option>
                   </select>
               </div>
               <div class="form-grp">
                   <label for="expected price" class="form-label">Expected Price:</label>
                   <input type="text" name="expected" class="form-input" id="expected">
               </div>
               <div class="form-grp">
                   <label for="expected price" class="form-label">Description:</label>
                   <textarea rows="3" cols="42"></textarea>

               </div>
               <button class="btn">Send</button>
           </form>
       </div>
   </section>


   <!---------------------------------Sell us End---------------------------->