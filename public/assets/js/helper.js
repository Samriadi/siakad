function addProgressClass(elementId) {
    $("#" + elementId)
      .addClass("btn-progress");
    localStorage.setItem(elementId + "Progress", "true");
  }
  
  function removeProgressClass(elementId) {
    $("#" + elementId)
      .removeClass("btn-progress");
    localStorage.removeItem(elementId + "Progress");
  }
  
  function checkProgressClassOnLoad(elementId) {
    if (localStorage.getItem(elementId + "Progress") === "true") {
      addProgressClass(elementId);
    } else {
      removeProgressClass(elementId);
    }
  }
  