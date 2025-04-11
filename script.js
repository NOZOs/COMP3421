const container = document.querySelector('.container')
const registerBtn = document.querySelector('.register-btn')
const loginBtn = document.querySelector('.login-btn')

//container become container.active if click the register button
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
})

//container.active become container if click the login button
loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
})