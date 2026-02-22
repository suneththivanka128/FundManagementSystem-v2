// RegNo Search
searchForm.onsubmit = function(e) {
  e.preventDefault();
  const reg = regNoInput.value;
  fetch(`api/get_history.php?reg=${reg}`)
    .then(res => res.json())
    .then(data => {
      historyTable.innerHTML = data.map(p => `<tr><td>${p.ForMonth} ${p.ForYear}</td><td>${p.Amount}</td><td>${p.PaymentDate}</td></tr>`).join('');
    });
};