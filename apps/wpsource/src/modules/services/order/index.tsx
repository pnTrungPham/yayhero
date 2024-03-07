import React from "react";

const Order: React.FC = () => (
  <>
    <div className="grid xl:grid-cols-8 lg:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 gap-4">
      {Array(10)
        .fill(0)
        .map((_, index) => (
          <div key={index}>
            <div></div>
          </div>
        ))}
    </div>
  </>
);

export default Order;
