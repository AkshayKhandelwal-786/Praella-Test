var chart = '';
function updateChart(labels,data)
{
  var options = {
    chart: {
      type: 'bar',
      height: 380
    },
    series: [{
      name: 'sales',
      data: data
    }],
    xaxis: {
      categories: labels
    }
  }
  chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
}

function Role(user,mobileRole) {
  if (user !== null) {
      return '<a href="javascript:void(0);" class="btn btn-xs btn-success" title="Active">' +
          (parseInt(user.role) === parseInt(Object.keys(mobileRole)[0]) ? mobileRole[1] : mobileRole[2]) +
          '</a>';
  } else {
      return 'N/A';
  }
}