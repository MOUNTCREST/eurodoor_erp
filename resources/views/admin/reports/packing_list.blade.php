
@extends('admin.layouts.app')

@section('content')


<div x-data="sorting">
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Packing List</h5>
                        <div class="panel">
							<div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                    <div class="mb-5 flex items-center gap-2">
                                        
                                      
                                    </div>
                                </div>

								<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
									<div>
									<label for="d_date">Delivery Date<span style="color: #EB2D30"></span> </label>
									<input type="date" name="d_date" id="d_date"  class="form-input" autofocus='autofocus' >
                                									</div>
                                                                    <div>
									<label for="porf">Fitting / Packing<span style="color: #EB2D30"></span> </label>
									<select id="porf" name="porf" class="form-input">
                                        <option val="">Select</option>
                                        <option value="Fitting">Fitting</option>
                                        <option value="Packing">Packing</option>
</select>
                                									</div>
									<div>

									
									<button type="button" id="btn_search" name="search"   class="btn btn-primary mt-4">Search <i class="fa fa-search position-right"></i></button>
</div>
								</div>
                            




                <div x-data="exportTable">
                        <div class="panel">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="mb-5 flex flex-wrap items-center">
                                   
                                    <button type="button" class="btn btn-primary btn-sm m-1" @click="generatePDF()">
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 ltr:mr-2 rtl:ml-2"
                                        >
                                            <path
                                                d="M15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM21.25 14C21.25 15.9068 21.2484 17.2615 21.1102 18.2892C20.975 19.2952 20.7213 19.8749 20.2981 20.2981L21.3588 21.3588C22.1071 20.6104 22.4392 19.6614 22.5969 18.489C22.7516 17.3382 22.75 15.8644 22.75 14H21.25ZM2.75 10C2.75 8.09318 2.75159 6.73851 2.88976 5.71085C3.02502 4.70476 3.27869 4.12511 3.7019 3.7019L2.64124 2.64124C1.89288 3.38961 1.56076 4.33855 1.40313 5.51098C1.24841 6.66182 1.25 8.13558 1.25 10H2.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25Z"
                                                fill="currentColor"
                                            />
                                            <path
                                                opacity="0.5"
                                                d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                        </svg>
                                        PDF
                                    </button>
                                    
                                    <button type="button" class="btn btn-primary btn-sm m-1" onclick="return printTable();">
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 ltr:mr-2 rtl:ml-2"
                                        >
                                            <path
                                                d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path
                                                d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                opacity="0.5"
                                                d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
                                            <path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        PRINT
                                    </button>
                                </div>
                            </div>
                            <table id="myTable"  class="table-hover whitespace-nowrap">
                            <thead>
                            <tr>
                            <th>Sl No</th>
                            <th>Party Name</th>
                            <th>Root Name</th>
                            <th>Batch No</th>
                            <th>Door No</th>
                            <th>Frame No</th>
                            <th>Finish Front</th>
                            <th>Finish Back</th>
                            <th>Lock</th>
                            <th>Delivery Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                            
                            </tbody>
                            </table>
                        </div>
                    </div>



                        </div>
 </div>






@endsection
@section('scripts')
        <!-- jsPDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
	<script>
  $(document).ready(function() {
  var style = $('<style>').appendTo('head');
  var css = '@media print { @page { size: A5 landscape; } table { background-color: transparent !important;overflow-x: auto;  } }';
  style.text(css);

});

</script>
        <script>
            
  document.addEventListener('alpine:init', () => {
  

    Alpine.data('exportTable', () => ({
                    datatable: null,
                    init() {
                        this.datatable = new simpleDatatables.DataTable('#myTable', {
                           
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            columns: [
                                {
                                    select: 0,
                                    sort: 'asc',
                                },
                                {
                                    select: 10,
                                    render: (data, cell, row) => {
                                        return this.formatDate(data);
                                    },
                                },
                            ],
                            firstLast: true,
                            firstText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            lastText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            prevText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            nextText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            labels: {
                                perPage: '{select}',
                            },
                            layout: {
                                top: '{search}',
                                bottom: '{info}{select}{pager}',
                            },
                        });
                        const additems = (newRowData) => { // Use an arrow function to retain the context

this.datatable.insert({
  data: [newRowData],
  
});

};

const refreshtbl = () => { // Use an arrow function to retain the context


this.datatable.destroy();
this.datatable.init();

};
$("#btn_search").click(function () {
     
    d_date = $("#d_date").val();
    porf = $("#porf").val();
     

  
     $.ajax({
       url: '{{route('get_report_of_packing_list')}}',
       type: 'GET',
       data: { d_date: d_date,porf:porf },
       success: function (data) {
       
        refreshtbl();

        var prev_balance = 0;
        if (data[0] === ''){
          const newRowData = ["No entries found"];
          additems(newRowData);
} else {
         // Add new rows to the DataTable
         $.each(data, function (key, value) {
         


          const newRowData = [value[0],value[1],value[2],value[3],value[4],value[5],value[6],value[7],value[8],value[9]];
          additems(newRowData);
          
         });

        }
       },
       error: function (jqXHR, textStatus, errorThrown) {
         // Your logic to handle the error
       },
     });
   });
                    },

                    exportTable(eType) {
                        var data = {
                            type: eType,
                            filename: 'table',
                            download: true,
                        };

                        if (data.type === 'csv') {
                            data.lineDelimiter = '\n';
                            data.columnDelimiter = ';';
                        }
                        else if (data.type === 'pdf') {
                          
      

        // Implement PDF export logic here
    } else {
        console.log('Invalid export type.');
    }
                        this.datatable.export(data);
                    },

    


                    formatDate(date) {
                        if (date) {
                            const dt = new Date(date);
                            const month = dt.getMonth() + 1 < 10 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
                            const day = dt.getDate() < 10 ? '0' + dt.getDate() : dt.getDate();
                            return day + '/' + month + '/' + dt.getFullYear();
                        }
                        return '';
                    },
                    
                }));
 
               
    
  });
 
</script>


<script>
  function generatePDF() {
    const doc = new jsPDF();
    const table = document.querySelector('#myTable');
    
    // Get table heading
    const headingRow = table.querySelector('thead tr');
    const headingDataCells = headingRow.querySelectorAll('th');
    const headingData = [];

    headingDataCells.forEach(cell => {
      headingData.push(cell.innerText);
    });

    // Print heading
    doc.setFontSize(12);
    doc.setFontStyle('bold');
    doc.text(10, 10, headingData.join(', '));

    // Get table body rows
    const bodyRows = table.querySelectorAll('tbody tr');

    bodyRows.forEach((row, index) => {
      const dataCells = row.querySelectorAll('td');
      const rowData = [];

      dataCells.forEach(cell => {
        rowData.push(cell.innerText);
      });

      // Print body data
      doc.setFontStyle('normal');
      doc.text(10, 20 + (index + 1) * 10, rowData.join(', '));
    });
    ledger_name = $("#ledger_id option:selected").text();
    doc.save('Ledger Report '+ledger_name+'.pdf');
  }

  window.generatePDF = generatePDF;
</script>

<!-- <script>
  document.addEventListener("DOMContentLoaded", function () {
    generatePDF();
  });
</script> -->


<script>
function printTable() {
    const d_date = $("#d_date").val();
const porf = $("#porf").val();
const url = `{{ route('print_packing_list', ['d_date' => ':d_date', 'porf' => ':porf']) }}`
    .replace(':d_date', encodeURIComponent(d_date))
    .replace(':porf', encodeURIComponent(porf));
    window.location.href = url;

}

    </script>














@endsection