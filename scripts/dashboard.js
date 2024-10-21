let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

const monthNames = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function generateCalendar(month, year) {
  const calendarBody = document.getElementById('calendar-body');
  calendarBody.innerHTML = ""; 

  const firstDay = new Date(year, month).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  let date = 1;
  let rowNeeded = Math.ceil((firstDay + daysInMonth) / 7); 
  
  for (let i = 0; i < rowNeeded; i++) {
    const row = document.createElement('tr');

    for (let j = 0; j < 7; j++) {
      const cell = document.createElement('td');
      if (i === 0 && j < firstDay) {
        cell.classList.add('empty');
      } else if (date > daysInMonth) {
        cell.classList.add('empty');
      } else {
        cell.textContent = date;
        date++;
      }
      row.appendChild(cell);
    }

    calendarBody.appendChild(row);
  }
}

function updatePreviewButton(month, year) {
  const previewBtn = document.getElementById('choose-month-year');
  previewBtn.textContent = `${monthNames[month]}, ${year}`;
}

const modal = document.getElementById('modal');
const openModalBtn = document.getElementById('choose-month-year');
const closeModalBtn = document.getElementById('close-modal');
const confirmSelectionBtn = document.getElementById('confirm-selection');

const monthSelect = document.getElementById('month-select');
const yearInput = document.getElementById('year-select');

openModalBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
  monthSelect.value = currentMonth; 
  yearInput.value = currentYear;    
});

closeModalBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

monthNames.forEach((month, index) => {
  const option = document.createElement('option');
  option.value = index;
  option.textContent = month;
  monthSelect.appendChild(option);
});

confirmSelectionBtn.addEventListener('click', () => {
  currentMonth = parseInt(monthSelect.value);
  currentYear = parseInt(yearInput.value);
  generateCalendar(currentMonth, currentYear);
  updatePreviewButton(currentMonth, currentYear); 
  modal.style.display = 'none'; 
});

generateCalendar(currentMonth, currentYear);

updatePreviewButton(currentMonth, currentYear);
