<template>
  <div class="invoice_payment">
    <v-container class="w-75 mb-6">
      <v-row>
        <v-col cols="12" sm="12" md="7" lg="7" xl="7" style="margin: 0px auto">
          <table
            width="600"
            border="0"
            cellpadding="0"
            cellspacing="0"
            class="fullTable"
            bgcolor="#ffffff"
            style="margin: 0px auto"
          >
            <tbody>
              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr></tr>
              <tr>
                <td>
                  <table
                    width="480"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    style="margin: 0 auto"
                    class="fullPadding"
                    bgcolor="#ffffff"
                  >
                    <tbody>
                      <tr>
                        <td>
                          <table
                            width="220"
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            align="left"
                            class="col_tb"
                          >
                            <tbody>
                              <tr>
                                <td align="left">
                                  <!-- <img
                                  src="add logo url here"
                                  width="32"
                                  height="32"
                                  alt="logo"
                                  border="0"
                                /> -->
                                  <p>Brand logo</p>
                                </td>
                              </tr>
                              <tr class="hiddenMobile">
                                <td height="40"></td>
                              </tr>
                              <tr class="visibleMobile">
                                <td height="20"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 12px;
                                    color: #5b5b5b;
                                    font-family: 'Open Sans', sans-serif;
                                    line-height: 18px;
                                    vertical-align: top;
                                    text-align: left;
                                  "
                                >
                                  Hello, address =>. <br />
                                  Thank you for shopping from our store and for
                                  your order.
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <table
                            width="220"
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            align="right"
                            class="col_tb"
                          >
                            <tbody>
                              <tr class="visibleMobile">
                                <td height="20"></td>
                              </tr>
                              <tr>
                                <td height="5"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 21px;
                                    color: #0146a6;
                                    letter-spacing: -1px;
                                    font-family: 'Open Sans', sans-serif;
                                    line-height: 1;
                                    vertical-align: top;
                                    text-align: right;
                                  "
                                >
                                  Invoice
                                </td>
                              </tr>
                              <tr></tr>
                              <tr class="hiddenMobile">
                                <td height="50"></td>
                              </tr>
                              <tr class="visibleMobile">
                                <td height="20"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 12px;
                                    color: #5b5b5b;
                                    font-family: 'Open Sans', sans-serif;
                                    line-height: 18px;
                                    vertical-align: top;
                                    text-align: right;
                                  "
                                >
                                  <small>ORDER</small> #800000025<br /><small
                                    >MARCH 4TH 2016</small
                                  >
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td height="20"></td>
              </tr>
            </tbody>
          </table>

          <table
            width="600"
            border="0"
            cellpadding="0"
            cellspacing="0"
            style="margin: 0 auto"
            class="fullTable"
            bgcolor="#ffffff"
          >
            <tbody>
              <tr></tr>
              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="40"></td>
              </tr>
              <tr>
                <td>
                  <table
                    width="480"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    style="margin: 0 auto"
                    class="fullPadding"
                  >
                    <tbody>
                      <tr>
                        <th
                          width="52%"
                          align="left"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #5b5b5b;
                            font-weight: normal;
                            line-height: 1;
                            vertical-align: top;
                            padding: 0px 10px 7px 0px;
                          "
                        >
                          Item
                        </th>
                        <th
                          align="left"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #5b5b5b;
                            font-weight: normal;
                            line-height: 1;
                            vertical-align: top;
                            padding: 0px 0px 7px;
                          "
                        >
                          <small>SKU</small>
                        </th>
                        <th
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #5b5b5b;
                            font-weight: normal;
                            line-height: 1;
                            vertical-align: top;
                            padding: 0px 0px 7px;
                            margin: 0 auto;
                          "
                        >
                          Quantity
                        </th>
                        <th
                          align="right"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #1e2b33;
                            font-weight: normal;
                            line-height: 1;
                            vertical-align: top;
                            padding: 0px 0px 7px;
                          "
                        >
                          Subtotal
                        </th>
                      </tr>
                      <tr>
                        <td
                          height="1"
                          colspan="4"
                          style="background: #bebebe"
                        ></td>
                      </tr>
                      <tr>
                        <td height="10" colspan="4"></td>
                      </tr>
                      <tr>
                        <td
                          class="article"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #0146a6;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          Plane title
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          <small>MH792AM/A</small>
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                            margin: 0 auto;
                          "
                        >
                          1
                        </td>
                        <td
                          align="right"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #1e2b33;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          $299.95
                        </td>
                      </tr>
                      <tr>
                        <td
                          height="1"
                          colspan="4"
                          style="border-bottom: 1px solid #e4e4e4"
                        ></td>
                      </tr>
                      <tr>
                        <td
                          class="article"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #0146a6;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          Plane title
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          <small>MHDV2G/A</small>
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                            margin: 0 auto;
                          "
                        >
                          1
                        </td>
                        <td
                          align="right"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #1e2b33;
                            line-height: 18px;
                            vertical-align: top;
                            padding: 10px 0px;
                          "
                        >
                          $29.95
                        </td>
                      </tr>
                      <tr>
                        <td
                          height="1"
                          colspan="4"
                          style="border-bottom: 1px solid #e4e4e4"
                        ></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td height="20"></td>
              </tr>
            </tbody>
          </table>
          <table
            width="600"
            border="0"
            cellpadding="0"
            cellspacing="0"
            style="margin: 0 auto"
            class="fullTable"
            bgcolor="#ffffff"
          >
            <tbody>
              <tr>
                <td>
                  <table
                    width="480"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    style="margin: 0 auto"
                    class="fullPadding"
                  >
                    <tbody>
                      <tr>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          Subtotal
                        </td>
                        <td
                          width="80"
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                            white-space: nowrap;
                          "
                        >
                          $329.90
                        </td>
                      </tr>
                      <tr>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          Shipping &amp; Handling
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #646a6e;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          $15.00
                        </td>
                      </tr>
                      <tr>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #000000;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          <strong>Grand Total (Incl.Tax)</strong>
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #000000;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          <strong>$344.90</strong>
                        </td>
                      </tr>
                      <tr>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #b0b0b0;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          <small>TAX</small>
                        </td>
                        <td
                          style="
                            font-size: 12px;
                            font-family: 'Open Sans', sans-serif;
                            color: #b0b0b0;
                            line-height: 22px;
                            vertical-align: top;
                            text-align: right;
                          "
                        >
                          <small>$72.40</small>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table
            width="600"
            border="0"
            cellpadding="0"
            cellspacing="0"
            style="margin: 0 auto"
            class="fullTable"
            bgcolor="#ffffff"
          >
            <tbody>
              <tr></tr>
              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="40"></td>
              </tr>
              <tr>
                <td>
                  <table
                    width="480"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    style="margin: 0 auto"
                    class="fullPadding"
                  >
                    <tbody>
                      <tr>
                        <td>
                          <table
                            width="220"
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            align="left"
                            class="col_tb"
                          >
                            <tbody>
                              <tr>
                                <td
                                  style="
                                    font-size: 11px;
                                    font-family: 'Open Sans', sans-serif;
                                    color: #5b5b5b;
                                    line-height: 1;
                                    vertical-align: top;
                                  "
                                >
                                  <strong>BILLING INFORMATION</strong>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" height="10"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 12px;
                                    font-family: 'Open Sans', sans-serif;
                                    color: #5b5b5b;
                                    line-height: 20px;
                                    vertical-align: top;
                                  "
                                >
                                  address =><br />
                                  address address address<br />
                                  New York NY<br />
                                  4468, United States<br />
                                  T: 000-000-0000
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <table
                            width="220"
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            align="right"
                            class="col_tb"
                          >
                            <tbody>
                              <tr class="visibleMobile">
                                <td height="20"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 11px;
                                    font-family: 'Open Sans', sans-serif;
                                    color: #5b5b5b;
                                    line-height: 1;
                                    vertical-align: top;
                                  "
                                >
                                  <strong>PAYMENT METHOD</strong>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" height="10"></td>
                              </tr>
                              <tr>
                                <td
                                  style="
                                    font-size: 12px;
                                    font-family: 'Open Sans', sans-serif;
                                    color: #5b5b5b;
                                    line-height: 20px;
                                    vertical-align: top;
                                  "
                                >
                                  Credit Card<br />
                                  Credit Card Type: Visa<br />
                                  Worldpay Transaction ID:
                                  <a
                                    href="#"
                                    style="
                                      color: #0146a6;
                                      text-decoration: underline;
                                    "
                                    >4185939336</a
                                  ><br /><a href="#" style="color: #b0b0b0"
                                    >Right of Withdrawal</a
                                  >
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>

              <tr class="hiddenMobile">
                <td height="60"></td>
              </tr>
              <tr class="visibleMobile">
                <td height="30"></td>
              </tr>
            </tbody>
          </table>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {
  data: () => ({
    featuredJob: [
      {
        id: "1",
        companyLogo: "assest/img/job-alerts/1-1.webp",
        title: "Software Engineer (Android), Libraries",
        companyName: "Segment",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Full Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-2.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-3.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-4.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
    ],
  }),
};
</script>

<style >
.invoice_payment div,
.invoice_payment p,
.invoice_payment a,
.invoice_payment li,
.invoice_payment td {
  -webkit-text-size-adjust: none;
}
.invoice_payment .ReadMsgBody {
  width: 100%;
  background-color: #ffffff;
}
.invoice_payment .ExternalClass {
  width: 100%;
  background-color: #ffffff;
}
.invoice_payment p {
  padding: 0 !important;
  margin-top: 0 !important;
  margin-right: 0 !important;
  margin-bottom: 0 !important;
  margin-left: 0 !important;
}
.invoice_payment .visibleMobile {
  display: none;
}
.invoice_payment .hiddenMobile {
  display: block;
}
@media only screen and (max-width: 600px) {
  .invoice_payment table[class="fullTable"] {
    width: 96% !important;
    clear: both;
  }
  .invoice_payment table[class="fullPadding"] {
    width: 85% !important;
    clear: both;
  }
  .invoice_payment table[class="col_tb"] {
    width: 45% !important;
  }
  .invoice_payment .erase {
    display: none;
  }
}
@media only screen and (max-width: 420px) {
  .invoice_payment table[class="fullTable"] {
    width: 100% !important;
    clear: both;
  }
  .invoice_payment table[class="fullPadding"] {
    width: 85% !important;
    clear: both;
  }
  .invoice_payment table[class="col_tb"] {
    width: 100% !important;
    clear: both;
  }
  .invoice_payment table[class="col_tb"] td {
    text-align: left !important;
  }
  .invoice_payment .erase {
    display: none;
    font-size: 0;
    max-height: 0;
    line-height: 0;
    padding: 0;
  }
  .invoice_payment .visibleMobile {
    display: block !important;
  }
  .invoice_payment .hiddenMobile {
    display: none !important;
  }
}
</style>
