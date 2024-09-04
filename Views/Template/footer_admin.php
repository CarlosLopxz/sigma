
  <div class="copyright">
    &copy; 2024 <a href="">Sigmasoft.</a>Todos los Derechos Reservados
  </div>
  
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script type="text/javascript">
      const salesData = {
  xAxis: {
    type: 'category',
    data: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom']
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      formatter: 'Hr {value}'
    }
  },
  series: [
    {
      data: [50, 30, 24, 28, 10, 17, 60],
      type: 'line',
      smooth: true,
      lineStyle: {
        color: '#ffd700', 
        width: 2 
      },
      itemStyle: {
        color: '#ffa500' 
      }
    }
  ],
  tooltip: {
    trigger: 'axis',
    formatter: "<b>{b0}:</b> Hr {c0}"
  }
};

      
      
      const supportRequests = {
      	tooltip: {
      		trigger: 'item'
      	},
      	legend: {
      		orient: 'vertical',
      		left: 'left'
      	},
      	series: [
      		{
      			name: '',
      			type: 'pie',
      			radius: '50%',
      			data: [
      				{ value: 190, name: 'Completadas' },
      				{ value: 70, name: 'En progreso' },
      				{ value: 130, name: 'En retraso' }
      			],
      			emphasis: {
      				itemStyle: {
      					shadowBlur: 10,
      					shadowOffsetX: 0,
      					shadowColor: 'rgba(0, 0, 0, 0.5)'


              },
            },
            itemStyle: {
                
                color: function(params) {
                    const colorList =['#7ed957', '#ffbd59', '#ff3131']

                    ;
                    return colorList[params.dataIndex];
                }
            }
        }
    ]
};
      
      const salesChartElement = document.getElementById('salesChart');
      const salesChart = echarts.init(salesChartElement, null, { renderer: 'svg' });
      salesChart.setOption(salesData);
      new ResizeObserver(() => salesChart.resize()).observe(salesChartElement);
      
      const supportChartElement = document.getElementById("supportRequestChart")
      const supportChart = echarts.init(supportChartElement, null, { renderer: 'svg' });
      supportChart.setOption(supportRequests);
      new ResizeObserver(() => supportChart.resize()).observe(supportChartElement);
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>




<script>
const base_url = "<?=base_url();?>";
</script>

<script type="text/javascript" src="<?=media();?>/js/functions_admin.js"></script>
<script src="<?=media();?>/js/<?=$data['page_functions_js'];?>"></script>

<!-- JavaScript -->
<script src="<?=media();?>/js/jquery-3.7.0.min.js"></script>
<script src="<?=media();?>/js/bootstrap.min.js"></script>

<script src="<?=media();?>/js/main.js"></script>

<script src="<?=media();?>/js/fontawesome.js"></script>
<script src="<?=media();?>/js/plugins/dropzone.js"></script>

<!-- Page specific javascripts-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

<!-- The javascript plugin to display page loading on top-->
<script src="<?=media();?>/js/plugins/pace.min.js"></script>

<!-- Page specific javascripts-->
<script src="
https://cdn.jsdelivr.net/npm/bootstrap-sweetalert@1.0.1/dist/sweetalert.min.js
"></script>
<!-- <script type="text/javascript" src="<?=media();?>/js/plugins/sweetalert.min.js"></script> -->
<script type="text/javascript" src="<?=media();?>/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?=media();?>/js/datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?=media();?>/js/datepicker/fecha.js"></script>
<script type="text/javascript" src="<?=media();?>/js/plugins/select2.min.js"></script>

<!-- Data table plugin-->
<script type="text/javascript" src="<?=media();?>/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=media();?>/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?=media();?>/js/plugins/bootstrap-select.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script src="<?=media();?>/js/datepicker/jquery-ui.min.js"></script>





</body>

</html>