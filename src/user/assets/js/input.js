$("#text")
  .focus(function () {
    $(".input_box").animate(
      {
        borderTopColor: "#3be5ae",
        borderLeftColor: "#3be5ae",
        borderRightColor: "#3be5ae",
        borderBottomColor: "#3be5ae",
      },
      200
    );
  })
  .blur(function () {
    $(".input_box").animate(
      {
        borderTopColor: "#d3d3d3",
        borderLeftColor: "#d3d3d3",
        borderRightColor: "#d3d3d3",
        borderBottomColor: "#d3d3d3",
      },
      200
    );
  });
