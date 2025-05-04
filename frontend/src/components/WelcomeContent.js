import * as React from 'react';

export default class WelcomeContent extends React.Component {
    render() {
        return (
            <div className={"row justify-content-md-center"}>
                <div className={"jumbotron jumbotron-fluid"}>
                    <div className={"container"}>
                        <h1 className={"display-4"}>Welcome to the front page</h1>
                        <p className={"lead"}>This is the front page, please login</p>
                    </div>
                </div>
            </div>
        )
    }
}
