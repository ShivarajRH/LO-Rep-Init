<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    Date.prototype.monthNames = [
                                    "January", "February", "March",
                                    "April", "May", "June",
                                    "July", "August", "September",
                                    "October", "November", "December"
                                ];

    Date.prototype.getMonthName = function() {
        return this.monthNames[this.getMonth()];
    };
    Date.prototype.getShortMonthName = function () {
        return this.getMonthName().substr(0, 3);
    };
    
    // usage:
    var d = new Date();
    alert(d.getMonthName());      // "October"
    alert(d.getShortMonthName()); // "Oct"
</script>