// Filter form
filterForm.onsubmit = function(e) {
  e.preventDefault();
  const month = document.getElementById('month').value;
  const year = filterForm.year.value;
  fetch(`api/filter_payees.php?month=${month}&year=${year}`)
    .then(res => res.json())
    .then(data => {
      completedTable.innerHTML = data.completed.map(p => `<tr><td>${p.RegNo}</td><td>${p.FullName}</td><td>${p.Amount}</td></tr>`).join('');
      notCompletedTable.innerHTML = data.notCompleted.map(p => `<tr><td>${p.RegNo}</td><td>${p.FullName}</td></tr>`).join('');
    });
};
