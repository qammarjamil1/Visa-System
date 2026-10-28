<!DOCTYPE html>
<html>
<head>
    <title>Visa Application Form</title>
<style>
    body{
        font-family: Arial;
        background: #f2f2f2;
        margin: 0;
        height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box{
        width: 400px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px gray;
    }

    input{
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        box-sizing: border-box;
    }

    button{
        width: 100%;
        padding: 10px;
        background: green;
        color: white;
        border: none;
    }

    button:hover{
        background: darkgreen;
    }
</style>
</head>

<body>

<div class="box">
    <h2>Visa Application Form</h2>

    <form method="POST" action="/visa">
        @csrf

        <input type="text" name="full_name" placeholder="Full Name">

        <input type="text" name="passport_number" placeholder="Passport Number">

        <input type="text" name="nationality" placeholder="Nationality">

        <input type="text" name="country_to_visit" placeholder="Country">

        <input type="date" name="travel_date">

        <button type="submit">Submit Application</button>
    </form>
</div>

</body>
</html>