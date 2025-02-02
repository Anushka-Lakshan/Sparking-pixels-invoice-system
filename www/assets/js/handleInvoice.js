$(document).ready(function () {
  var rowCount = $(".itemRow").length; // Corrected selector

  var itemRow = "";

  //   add item row
  $("#add-row").on("click", function () {
    rowCount++;
    itemRow = `
      <tr>
      <td><input class="itemRow" type="checkbox"></td>
      <td><input type="text" name="item[]" id="itemName_${rowCount}" autocomplete="off" class="form-control"></td>
      <td>
  
          <textarea name="description[]" id="" cols="30" rows="3" class="form-control" id="itemDescription_${rowCount}"></textarea>
      </td>
      <td><input type="number" name="unitCost[]" id="itemUnitCost_${rowCount}" autocomplete="off" class="form-control" value="0.00"></td>
      <td><input type="number" name="quantity[]" id="itemQuantity_${rowCount}" autocomplete="off" class="form-control" min="1" value="1" ></td>
      <td><input type="text" name="" id="itemTotal_${rowCount}" autocomplete="off" class="form-control" readonly></td>
      </tr>`;

    $("#itemTable").append(itemRow);
  });

  // add package row

  $("#add-package").on("click", function () {
    let packageOptions = packages;
    packages.forEach((package) => {
      packageOptions += `<option value="${package.id}">${package.Item} :  ${package.UnitCost}LKR</option>`;
    });

    Swal.fire({
      title: "Select Package",
      html: `<select id="packageSelect" class="form-control">${packageOptions} </select>`,
      showCancelButton: true,
      confirmButtonText: "Add",
      cancelButtonText: "Cancel",
      focusConfirm: false,
      preConfirm: () => {
        const packageId = $("#packageSelect").val();
        const selectedPackage = packages.find(
          (package) => package.id == packageId
        );
        if (selectedPackage) {
          addPackageToTable(selectedPackage);
        }
      },
    });
  });

  function addPackageToTable(package) {
    rowCount++;
    const itemRow = `
      <tr>
      <td><input class="itemRow" type="checkbox"></td>
      <td><input type="text" name="item[]" id="itemName_${rowCount}" autocomplete="off" class="form-control" value="${package.Item}" ></td>
      <td>
          <textarea name="description[]" id="itemDescription_${rowCount}" cols="30" rows="3" class="form-control" >${package.Description}</textarea>
      </td>
      <td><input type="number" name="unitCost[]" id="itemUnitCost_${rowCount}" autocomplete="off" class="form-control" value="${package.UnitCost}" ></td>
      <td><input type="number" name="quantity[]" id="itemQuantity_${rowCount}" autocomplete="off" class="form-control" min="1" value="1" ></td>
      <td><input type="text" name="" id="itemTotal_${rowCount}" autocomplete="off" class="form-control" readonly value="${package.UnitCost}"></td>
      </tr>`;

    $("#itemTable").append(itemRow);
    calculateTotal();
  }

  // remove item row
  $("#remove-row").on("click", function () {
    let count = $(".itemRow:checked").length;

    if (count == 0) {
      Swal.fire({
        title: "Attention!",
        text: "Please select at least one item.",
        icon: "warning",
        showCancelButton: false,
        confirmButtonText: "Continue",
      });
    }
    $(".itemRow:checked").each(function () {
      $(this).closest("tr").remove();
    });
    calculateTotal();
  });

  //   payment opertions

  var paymentRowCount = $("#paymentTable > tr").length;

  var paymentRow = ""; // Moved definition outside click event listener

  $(document).on("click", "#add-payment", function () {
    paymentRowCount++;
    let date = new Date().toISOString().slice(0, 10);
    let formatedDate = moment(date, "YYYY-MM-DD").format("DD MMMM YYYY");
    paymentRow = `
        <tr>
        <td><input class="paymentRow" type="checkbox"></td>
        <td><input type="text" name="paymentName[]" id="paymentName_${paymentRowCount}" autocomplete="on" class="form-control"></td>
        <td><input type="date" class="form-control" name="paymentDate[]" id="paymentDate_${paymentRowCount}" value="${date}" data-date="${formatedDate}" data-date-format="DD MMMM YYYY"></td>
        <td><input type="number" name="paymentAmount[]" id="paymentAmount_${paymentRowCount}" autocomplete="off" class="form-control" value="0"></td> <!-- Removed extra space -->
        </tr>`;

    $("#paymentTable").append(paymentRow);
  });

  // remove payment row
  $("#remove-payment").on("click", function () {
    let count = $(".paymentRow:checked").length;

    if (count == 0) {
      Swal.fire({
        title: "Attention!",
        text: "Please select at least one payment item.",
        icon: "warning",
        showCancelButton: false,
        confirmButtonText: "Continue",
      });
    }
    $(".paymentRow:checked").each(function () {
      $(this).closest("tr").remove();
    });
    calculateTotal();
  });

  //     calculate total

  function calculateTotal() {
    var Total = 0;
    $("[id^=itemUnitCost_]").each(function () {
      // Total += parseFloat($(this).val());
      var id = $(this).attr("id");
      id = id.replace("itemUnitCost_", "");

      let unitPrice = $("#itemUnitCost_" + id).val();
      if (!unitPrice) {
        unitPrice = 0;
        $("#itemUnitCost_" + id).val(0);
      }
      let quantity = $("#itemQuantity_" + id).val();
      if (!quantity) {
        quantity = 1;
        $("#itemQuantity_" + id).val(1);
      }

      let lineTotal = unitPrice * quantity;

      $("#itemTotal_" + id).val(toMoney(lineTotal));

      Total += parseFloat(lineTotal);
    });

    var totalPayment = 0;
    $("[id^=paymentAmount_]").each(function () {
      let value = $(this).val();
      if (!value) {
        value = 0;
        $(this).val(0);
      }

      totalPayment += parseFloat(value);
    });

    $("#subTotal").val(toMoney(Total));
    $("#Totalpayments").val(toMoney(totalPayment));

    let discount = $("#discount").val();
    if (!discount) {
      discount = 0;
      $("#discount").val(parseFloat(discount).toFixed(2));
    }

    let due =
      parseFloat(Total) - parseFloat(discount) - parseFloat(totalPayment);

    $("#balance").val(toMoney(due));
  }

  $(document).on("change", "[id^=itemQuantity_]", function () {
    calculateTotal();
  });
  $(document).on("blur", "[id^=itemUnitCost_]", function () {
    calculateTotal();
  });
  $(document).on("blur", "#discount", function () {
    calculateTotal();
  });
  $(document).on("blur", "[id^=paymentAmount_]", function () {
    calculateTotal();
  });

  $(document).on("change", "input[type='date']", function (e) {
    $(this).attr(
      "data-date",
      moment($(this).val(), "YYYY-MM-DD").format(
        $(this).attr("data-date-format")
      )
    );
  });

  //   $("form").on("keypress", function (e) {
  //     calculateTotal();
  //     return e.which !== 13;
  //   });
  $("form").on("keypress", function (e) {
    let target = e.target;
    if (!isCKEditorElement(target) && e.which === 13) {
      calculateTotal();
      e.preventDefault();
    }
  });

  function isCKEditorElement(element) {
    // Check if the element has a CKEditor instance associated with it

    if (
      element.tagName.toLowerCase() == "textarea" ||
      element.classList.contains("ck-editor__editable")
    ) {
      return true;
    }

    // let result =
    //   element.tagName.toLowerCase() === "textarea" &&
    //   element.classList.contains("ck-editor__editable");
    // console.log(element);
    // return result;
  }

  $("#newInvoice").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    calculateTotal();

    var subTotal = parseFloat($("#subTotal").val());
    if (subTotal == 0) {
      Swal.fire({
        title: "Attention!",
        text: "There no items in the invoice.",
        icon: "warning",
        showCancelButton: false,
        confirmButtonText: "Continue",
      });
      return false;
    }
    // var notesData = notes.getContent();

    // var termsData = terms.getContent();

    // // Append the additional data to the form data
    // $(this).append(
    //   '<input type="hidden" name="notes" value="' + notesData + '">'
    // );
    // $(this).append(
    //   '<input type="hidden" name="terms" value="' + termsData + '">'
    // );
    // Get the value of the clicked button and set it to the hidden input field
    var submitButtonValue = $(event.originalEvent.submitter).val();
    $("#submitButton").val(submitButtonValue);

    $(this).unbind("submit").submit();
  });

  function toMoney(number) {
    return number.toLocaleString("en-US", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  }

  // Function to remove commas and convert the formatted number back to a number
  function toNumber(formattedNumber) {
    return parseFloat(formattedNumber.replace(/,/g, ""));
  }
});
