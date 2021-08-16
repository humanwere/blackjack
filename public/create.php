<div class="container">
    <div class="container-fluid py-5 row">
        <form action="/create" method="POST">
            <div class="form-group mt-3">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group mt-3">
                <label for="exampleInputEmail1">Delay</label>
                <input type="text" class="form-control" name="delay" id="delay" placeholder="Enter delay time">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Game</button>
        </form>
    </div>
</div>