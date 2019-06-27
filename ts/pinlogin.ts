class PinLogin {

    el: any;
    loginEndpoint: any;
    redirectTo: string;
    maxNumbers: number;
    value: any;

    constructor({ el, loginEndpoint, redirectTo, maxNumbers = Infinity }: { el: any, loginEndpoint: any, redirectTo: string, maxNumbers: number }) {
        this.el = {
            main: el,
            numPad: el.querySelector(".pin-login__numpad"),
            textDisplay: el.querySelector(".pin-login__text")
        };

        this.loginEndpoint = loginEndpoint;
        this.redirectTo = redirectTo;
        this.maxNumbers = maxNumbers;
        this.value = "";

        this.generatePad();
    }

    generatePad = () => {
        const padLayout = [
            "1", "2", "3",
            "4", "5", "6",
            "7", "8", "9",
            "C", "0", "V"
        ];

        padLayout.forEach(key => {
            const insertBreak = key.search(/[369]/) !== -1;
            const keyEl = document.createElement("div");

            keyEl.classList.add("pin-login__key");
            keyEl.classList.toggle("material-icons", isNaN(Number(key)));
            keyEl.textContent = key;
            keyEl.addEventListener("click", () => { this.handleKeyPress(key) });
            this.el.numPad.appendChild(keyEl);

            if (insertBreak) {
                this.el.numPad.appendChild(document.createElement("br"));
            }
        })
    }

    handleKeyPress = (key: string) => {
        switch (key) {
            case "C":
                this.value = this.value.substring(0, this.value.length - 1);
                break;
            case "V":
                this.attemptLogin();
                break;
            default:
                if (this.value.length < this.maxNumbers && !isNaN(Number(key))) {
                    this.value += key;
                }
                break;
        }

        this.updateValueText();
    }

    updateValueText = () => {
        this.el.textDisplay.value = "_".repeat(this.value.length);
    }

    attemptLogin() {
        if (this.value.length > 0) {
            fetch(this.loginEndpoint, {
                method: "post",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `pincode=${this.value}`
            }).then(response => {
                if (response.status === 200) {
                    window.location.href = this.redirectTo;
                }
                else {
                    this.el.textDisplay.classList.add("pin-login__text--error");
                }
            })
        }
    }
}