import * as React from 'react';

import { request } from '../axios_helper';

export default class AuthContent extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data : []
        };
    };

    componentDidMount() {
        request(
            "GET",
            "/messages",
            {}
        ).then(response => {
            console.log('Response data:', response.data);
            this.setState({data : response.data})
        });
    };

    render() {
        console.log('Console says hi!')
        return (
            <div className={"row justify-content-md-center"}>
                <div className = "col-4">
                    <div className={"card"} style={{ width: "18rem"}}></div>
                        <div className={"card-body"}>
                            <h1>Auth Content</h1>
                            <h5 className={"card-title"}>Backend response</h5>
                            <p className={"card-text"}>Content:
                                {this.state.data && this.state.data.map((item) => <li key={item}>{item}</li>)}
                            </p>
                        </div>
                </div>
            </div>
        )
    }
}
