import './App.css'
import logo from '../logo.svg'

import Header from './Header'
import AppContent from "./AppContent";


function App() {
    return (
        <div>
            <Header pageTitle="front page" logoSrc={logo}/>
            <div className={"container-fluid"}>
                <div className={"row"}>
                    <div className={"col"}>
                        {/*<div className={"col-md-12"}></div>*/}
                        <AppContent/>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default App;
