import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';
import axios from 'axios';

export default function Upload(props) {

    const [file, setFile] = React.useState(null);

    const handleChange = (e) => {
        setFile(e.target.files[0]);
    }

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();

        formData.append('file', file);
        
        axios.post('/upload', formData)
        .then(res => {
            console.log(res);
            window.location.href = '/files';
        })
        .catch(err => {
            console.log(err);
        }
        );
    }


    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Upload</h2>}
        >
            <Head title="Upload" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        {/* Input file */}
                        <div className="p-6 bg-white border-b border-gray-200">
                            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="file">
                                File
                            </label>
                            <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="file" type="file" onChange={handleChange} />

                            <p className="text-gray-500 text-xs italic">
                                Please upload a file less than 5MB.
                            </p>

                            <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onClick={handleSubmit}>
                                Upload
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </Authenticated>
    );

}

