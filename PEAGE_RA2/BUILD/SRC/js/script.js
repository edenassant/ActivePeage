function sendForm(formId, endpoint) {
    console.log("Binding form : " + formId);
    const form = document.getElementById(formId);

    if (!form) {
        console.error(`Formulaire avec id '${formId}' non trouvé`);
        return;
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log("Form submitted : " + formId);

        const formData = new FormData(this);

        if (formId === "form-client-carte") {
            const c_code = formData.get("code_client")?.trim();
            const ca_code = formData.get("numero_carte")?.trim();
            console.log(c_code);
            console.log(ca_code);

            if (c_code && ca_code) {

                endpoint = "carte_details.php";
            } else if (c_code && !ca_code) {

                endpoint = "search_client_carte.php";
            } else {

                alert("Veuillez saisir au minimum le code client.");
                return;
            }

            console.log("Endpoint choisi :", endpoint);
        }


        fetch(`ajax/${endpoint}`, {
            method: "POST",
            body: formData
        })
            .then(res => res.text())
            .then(html => {
                document.getElementById("result-zone").innerHTML = html;
            })
            .catch(err => {
                console.error("Erreur AJAX : ", err);
            });
    });
}


// Bind des formulaires
sendForm("form-client-carte", "search_client_carte.php");
sendForm("form-raison", "search_raison_sociale.php");
sendForm("form-libre", "search_libre.php");
sendForm("form-immat", "search_immat.php");


function loadCarteDetail(c_code, ca_code) {
    // Préparer les données en format x-www-form-urlencoded
    const params = new URLSearchParams();
    params.append("code_client", c_code);
    params.append("numero_carte", ca_code);

    fetch("ajax/carte_details.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: params.toString()
    })
        .then(res => res.text())
        .then(html => {
            document.getElementById("result-zone").innerHTML = html;
        })
        .catch(err => {
            console.error("Erreur AJAX : ", err);
        });
}

function loadClientDetail(c_code,) {
    // Préparer les données en format x-www-form-urlencoded
    const params = new URLSearchParams();
    params.append("code_client", c_code);

    fetch("ajax/search_client_carte.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: params.toString()
    })
        .then(res => res.text())
        .then(html => {
            document.getElementById("result-zone").innerHTML = html;
        })
        .catch(err => {
            console.error("Erreur AJAX : ", err);
        });
}