<table class="captcha_table">
            <tr class="captcha_row">
                <td align="center">

                    <table>
                         <tr>
                             <td>
                                 <? $this->__write_captcha_image() ?>
                             </td>
                         </tr>
                        <tr>
                            <td align="center">
                                <? $this->__write_listen_captcha() ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <? $this->__write_change_captcha() ?>
                            </td>
                        </tr>
                    </table>

                </td>

                <td align="center">

                    <? $this->__write_form_label() ?>

                    <br />

                    <? $this->__write_form_field() ?>
                   
                </td>

            </tr>
        </table>