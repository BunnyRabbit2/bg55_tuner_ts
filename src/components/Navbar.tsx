import React from "react";

export default function Navbar() {
  return (
    <nav
      className="relative shadow-lg bg-white shadow-lg flex flex-wrap items-center justify-between px-2 py-3"
    >
      <div className="container px-4 mx-auto flex flex-wrap items-center justify-between">
        <div className="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
          <a
            className="text-gray-800 text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase"
          >
            BG55 Forza Tuner
          </a>
        </div>
        <div
          className="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none"
          id="example-navbar-warning"
        >
          <ul className="flex flex-col lg:flex-row list-none mr-auto">
            <li className="flex items-center">
              <a
                className="text-gray-800 hover:text-gray-600 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold"
                href=""
              >
                <i
                  className="text-gray-500 far fa-file-alt text-lg leading-lg mr-2"
                />{" "}
                Docs
              </a>
            </li>
          </ul>
          <ul className="flex flex-col lg:flex-row list-none lg:ml-auto">
            
          </ul>
        </div>
      </div>
    </nav>
  );
}
