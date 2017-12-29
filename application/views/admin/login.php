<div class="container">



    <div class="grid grid12_12">

        <a href="home"><h3><span class="fat typicons-left"></span>Back to home</h3></a>

    </div>





    <div class="grid grid3_12">

        &nbsp;

    </div>



    <div class="grid grid6_12" style="text-align:center">



        <h2 class="inline">Login</h2><h3 class="inline">&nbsp;to your account</h3>



 
        <!-- <form action="work" method="post"> -->



        <?php echo form_open('admin/login'); ?>



        <table>

            <tr>
            
           

                <td><label for="emailaddress">Email Address</label></td>

                <td>&nbsp;:&nbsp;</td>

                <td><input type="text" name="emailaddress" id="emailaddress" value=<?php set_value('emailaddress');?>></td>

            </tr>

            <?php if(form_error('email')): ?>

            <tr>

            	<td></td>

                <td></td>

                <td><div class="msgbar error"><?php echo form_error('email');?></div></td>

            </tr>

            <?php endif; ?>

            <tr>

                <td><label for="password">Password</label></td>

                <td>&nbsp;:&nbsp;</td>

                <td><input type="password" name="password" id="password"></td>

            </tr>

            <?php if(form_error('password')): ?>

            <tr>

            	<td></td>

                <td></td>

                <td><div class="msgbar error"><?php echo form_error('password');?></div></td>

            </tr>

            <?php endif; ?>

            <tr>

                <td></td>

                <td></td>

                <td><br><button type="submit" name="login" id="login" class="button red"><span class="typicons-tick">&nbsp;Login</span></button><br/><br><span class="typicons-lock "></span><a href="">Forgot your password or username?</a>  </td>

            </tr>



        </table>





        </form>



    </div>



    <div class="grid grid3_12">

        &nbsp;

    </div>



</div>