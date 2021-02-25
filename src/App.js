import React, { Component } from 'react';
import axios from 'axios';
import './App.css';

class App extends Component {

  constructor(props){
    super(props);
    this.state = {
        userInputField: '',
        result: ''
    }
    this.submit = this.submit.bind(this);
    this.onChange = this.onChange.bind(this);
  }

  onChange(e) {
      this.setState({userInputField: e.target.value})
  }
  submit(e) {
    e.preventDefault();
    // CHANGE URL TO CORRECT PATH
    const postURL = "http://localhost:8888/consumerreports/server.php";

    axios.post(postURL, this.state.userInputField)
    //.then(res => console.log('res.data: ', res.data)) // debugging
    .then(res => this.setState({result: res.data.results}))
  }

  render() {

    return (
      <div className="App">
        <header className="App-header">
          <h1>The Amazing AB-12 Info App</h1>
        </header>
        <section>
          <h2>Enter your A's & B's below:</h2>
          <form onSubmit={this.submitHandler}>
              <input type="text" name="userInputField" onChange={this.onChange} />
              <input type="submit" name="submit" onClick={this.submit} />
          </form>
          <p>{this.state.result}</p>
        </section>
      </div>
    );
  };
}

export default App;
