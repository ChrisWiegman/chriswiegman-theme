jQuery(document).ready(function(e) {
    !function() {
        e(document.getElementById("add-row")).on("click", function() {
            var t = e(".empty-row.screen-reader-text").clone(!0);
            return t.removeClass("empty-row screen-reader-text"), t.insertBefore("#repeatable-fieldset tbody>tr.main:last"), 
            e(".date-field").each(function() {
                0 === e(this).closest(".empty-row").length && (e(this).datepicker("destroy"), e(this).datepicker());
            }), !1;
        });
    }(), e(".remove-row").on("click", function() {
        return e(this).closest("tr.main").remove(), !1;
    }), e(".date-field").each(function() {
        e(this).datepicker();
    });
});
//# sourceMappingURL=admin-speaking.js.map