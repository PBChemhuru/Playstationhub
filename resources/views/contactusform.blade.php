<x-app-layout>
    <form method="POST" action="{{ route('contactusemail') }}">
        @csrf
        <label for="email">Email</label><br>
        <input type="text" placeholder="Enter email" id="email" name="email"><br>
        @error('email')
            <p style="color:red;size:13px">{{ $message }}</p>
        @enderror
        <label for="phonenumber">Phone Number</label><br>
        <input type="text" placeholder="Enter Phonenumber" id="phonenumber" name="phonenumber"><br>
        @error('phonenumber')
            <p style="color:red;size:13px">{{ $message }}</p>
        @enderror
        <label for="subject">Subject</label><br>
        <input type="text" id="subject" name="subject"></input><br>
        @error('subject')
            <p style="color:red;size:13px">{{ $message }}</p>
        @enderror
        <label for="message">Message</label><br>
        <textarea id="message" name="message"></textarea><br>
        @error('message')
            <p style="color:red;size:13px">{{ $message }}</p>
        @enderror

        <button class="btn btn-primary my-6" type="submit" sty>Submit</button>
    </form>
</x-guest-layout>
